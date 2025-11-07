<?php

namespace App\Http\Controllers;

use App\Models\ServiceRequest;
use App\Models\Service;
use App\Models\User;
use App\Mail\ServiceRequestConfirmationMail;
use App\Mail\AdminServiceRequestNotificationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Events\ClientActivity;

class ServiceRequestController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'service_id' => 'required|exists:services,id',
            'nom' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telephone' => 'required|string|max:20',
            'adresse' => 'required|string',
            'description' => 'required|string',
            'date_souhaitee' => 'nullable|date',
            'champs_specifiques' => 'nullable|array'
        ]);

        $service = Service::findOrFail($validatedData['service_id']);
        
        $serviceRequest = ServiceRequest::create([
            'service_id' => $validatedData['service_id'],
            'nom' => $validatedData['nom'],
            'email' => $validatedData['email'],
            'telephone' => $validatedData['telephone'],
            'adresse' => $validatedData['adresse'],
            'description' => $validatedData['description'],
            'date_souhaitee' => $validatedData['date_souhaitee'],
            'champs_specifiques' => $validatedData['champs_specifiques'] ?? [],
            'status' => 'pending'
        ]);

        try {
            // Envoyer l'e-mail de confirmation au client
            Mail::to($validatedData['email'])->send(new ServiceRequestConfirmationMail($serviceRequest));
            
            // Envoyer une notification à tous les administrateurs
            Mail::to(User::getAdminEmails())->send(new AdminServiceRequestNotificationMail($serviceRequest));
            
            Log::info('Emails de demande de service envoyés avec succès', [
                'service_request_id' => $serviceRequest->id,
                'client_email' => $validatedData['email'],
                'admin_emails' => User::getAdminEmails()
            ]);
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'envoi des emails de demande de service', [
                'error' => $e->getMessage(),
                'service_request_id' => $serviceRequest->id
            ]);
        }

        // Déclencher l'événement pour notifier les administrateurs
        event(new ClientActivity('service_request', [
            'name' => $validatedData['nom'],
            'email' => $validatedData['email'],
            'id' => $serviceRequest->id,
            'service' => $service->nom
        ]));

        return redirect()->route('services.confirmation', $serviceRequest)
            ->with('success', 'Votre demande de service a été enregistrée avec succès.');
    }

    public function confirmation(ServiceRequest $serviceRequest)
    {
        return view('services.confirmation', compact('serviceRequest'));
    }
}