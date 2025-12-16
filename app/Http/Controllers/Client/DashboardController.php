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
            // Récupérer les cours récents
            $courses = Course::orderBy('created_at', 'desc')
                ->take(5)
                ->get();

            // Récupérer les étudiants actifs
            $students = Student::where('status', 'active')
                ->take(10)
                ->get();

            // Statistiques d'étudiants
            $studentStats = [
                'total' => Student::count(),
                'active' => Student::where('status', 'active')->count(),
                'graduated' => Student::where('status', 'graduated')->count(),
                'inactive' => Student::where('status', 'inactive')->count(),
            ];

            // Statistiques de cours
            $courseStats = [
                'total' => Course::count(),
                'active' => Course::where('status', 'active')->count(),
                'upcoming' => Course::where('status', 'upcoming')->count(),
                'completed' => Course::where('status', 'completed')->count(),
            ];
        } catch (\Exception $e) {
            // Si les tables n'existent pas encore, fournir des données par défaut
            $courses = collect([]);
            $students = collect([]);
            $studentStats = [
                'total' => 0,
                'active' => 0,
                'graduated' => 0,
                'inactive' => 0,
            ];
            $courseStats = [
                'total' => 0,
                'active' => 0,
                'upcoming' => 0,
                'completed' => 0,
            ];
        }

        // Filtrage des activités
        try {
            $activitesQuery = LogActivite::where('user_id', $user->id);

            if ($request->has('action')) {
                $activitesQuery->where('action', $request->action);
            }

            if ($request->has('date')) {
                switch ($request->date) {
                    case 'aujourd\'hui':
                        $activitesQuery->whereDate('created_at', today());
                        break;
                    case 'semaine':
                        $activitesQuery->where('created_at', '>=', now()->startOfWeek());
                        break;
                    case 'mois':
                        $activitesQuery->where('created_at', '>=', now()->startOfMonth());
                        break;
                }
            }

            $activites = $activitesQuery->latest()->paginate(10);
        } catch (\Exception $e) {
            $activites = collect([]);
        }

        // Récupérer les notifications non lues
        try {
            $notifications = $user->notifications()
                ->whereNull('read_at')
                ->latest()
                ->take(5)
                ->get();
        } catch (\Exception $e) {
            $notifications = collect([]);
        }

        return view('dashboard', compact(
            'courses',
            'students',
            'studentStats',
            'courseStats',
            'activites',
            'notifications'
        ));
    }
}
