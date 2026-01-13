<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Installation;
use App\Models\Product;
use App\Models\Order;
use App\Models\Devis;
use App\Models\Functionality;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
        // Statistiques globales
        $totalUtilisateurs = \App\Models\User::count();
        $tauxSatisfaction = 92; // Valeur exemple

        return view('dashboards.admin', compact(
            'totalUtilisateurs',
            'tauxSatisfaction'
        ));
    }
}
