<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Course;
use App\Models\LogActivite;
use App\Models\Utilisateur;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

/**
 * Contrôleur pour gérer le tableau de bord client
 */
class DashboardController extends Controller
{
    /**
     * Constructeur du contrôleur
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Affiche le tableau de bord de l'utilisateur
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $user = auth()->user();

        try {
            // Statistiques pour le dashboard enseignant
            $courtsActifs = 3; // Nombre de cours actifs
            $totalEtudiants = 105; // Total d'étudiants
            $tauxPresence = 87; // Taux de présence moyen
            $tachesPendantes = 4; // Nombre de tâches à faire

            return view('dashboards.enseignant', [
                'courtsActifs' => $courtsActifs,
                'totalEtudiants' => $totalEtudiants,
                'tauxPresence' => $tauxPresence,
                'tachesPendantes' => $tachesPendantes,
            ]);
        } catch (\Exception $e) {
            return view('dashboards.enseignant', [
                'courtsActifs' => 0,
                'totalEtudiants' => 0,
                'tauxPresence' => 0,
                'tachesPendantes' => 0,
            ]);
        }
    }
}
