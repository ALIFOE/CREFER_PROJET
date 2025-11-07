<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FormationInscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class FormationInscriptionController extends Controller
{    
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }    public function index(Request $request)
    {
        $query = FormationInscription::with('formation');

        if ($request->filled('formation_id')) {
            $query->where('formation_id', $request->formation_id);
        }

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('telephone', 'like', "%{$search}%")
                  ->orWhereHas('formation', function($q) use ($search) {
                      $q->where('titre', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->has('export')) {
            return $this->exportToExcel($query->get());
        }

        $inscriptions = $query->latest()->paginate(10)->withQueryString();
        $formations = \App\Models\Formation::orderBy('titre')->get();
        
        return view('admin.formations.inscriptions.index', compact('inscriptions', 'formations'));
    }

    protected function exportToExcel($inscriptions)
    {
        // À implémenter si nécessaire
        return back()->with('error', 'Fonctionnalité d\'export en cours de développement');
    }

    public function updateStatus(Request $request, FormationInscription $inscription)
    {
        $request->validate([
            'statut' => 'required|in:acceptee,en_attente,refusee'
        ]);

        $oldStatut = $inscription->statut;
        $inscription->update(['statut' => $request->statut]);

        try {
            // Envoi du mail approprié selon le statut
            $mailClass = match($request->statut) {
                'acceptee' => \App\Mail\FormationAcceptedMail::class,
                'refusee' => \App\Mail\FormationRejectedMail::class,
                'en_attente' => \App\Mail\FormationPendingMail::class,
            };

            \Mail::to($inscription->email)->send(new $mailClass($inscription));

            \Log::info('Mail de changement de statut envoyé', [
                'inscription_id' => $inscription->id,
                'ancien_statut' => $oldStatut,
                'nouveau_statut' => $request->statut,
                'email' => $inscription->email
            ]);

        } catch (\Exception $e) {
            \Log::error('Erreur lors de l\'envoi du mail de changement de statut', [
                'error' => $e->getMessage(),
                'inscription_id' => $inscription->id,
                'email' => $inscription->email
            ]);
            
            return back()->with('error', 'Le statut a été mis à jour mais l\'envoi du mail a échoué.');
        }

        return back()->with('success', 'Le statut de l\'inscription a été mis à jour.');
    }

    public function destroy(FormationInscription $inscription)
    {
        if (!in_array($inscription->statut, ['refusee', 'validee'])) {
            return back()->with('error', 'Cette inscription ne peut pas être supprimée.');
        }

        $inscription->delete();

        return back()->with('success', 'L\'inscription a été supprimée avec succès.');
    }

    public function downloadDocument(FormationInscription $inscription, $type)
    {
        $path = match($type) {
            'acte_naissance' => $inscription->acte_naissance_path,
            'cni' => $inscription->cni_path,
            'diplome' => $inscription->diplome_path,
            default => abort(404)
        };

        if (!Storage::exists($path)) {
            abort(404, 'Document non trouvé');
        }

        return response()->download(storage_path('app/' . $path));
    }
}
