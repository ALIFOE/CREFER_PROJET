<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\Client\DashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Client\InstallationController;
use App\Http\Controllers\Client\RealtimeDataController;
use App\Http\Controllers\DimensionnementController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\LogActiviteController;
use App\Http\Controllers\TechnicianController;
use App\Http\Controllers\SuiviProductionController;
use App\Http\Controllers\RapportController;
use App\Http\Controllers\MeteoController;
use App\Http\Controllers\RegionalPerformanceController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\Admin\FormationController as AdminFormationController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\FormationController;
use App\Http\Controllers\Admin\FormationInscriptionController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\OptimisationController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\RapportsController;

// Route de migration temporaire (à supprimer après)
Route::get('/migrate-now', function () {
    if (!env('APP_DEBUG')) {
        abort(403);
    }
    
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        return response()->json(['message' => 'Migrations exécutées avec succès']);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
});

// Routes publiques
Route::get('/', function () {
    return view('home');
})->name('home');

// Route de raccourci pour le dimensionnement
Route::get('/dimensionnement', [DimensionnementController::class, 'create'])->name('dimensionnement');

// Routes pour les formations
Route::prefix('formation')->group(function () {
    Route::get('/', [FormationController::class, 'index'])->name('formation');
    Route::get('/inscription', [FormationController::class, 'show'])->name('inscription');
    Route::post('/inscription', [FormationController::class, 'inscription'])->middleware(['auth'])->name('formation.inscription');
    Route::get('/mes-inscriptions', [FormationController::class, 'mesInscriptions'])->middleware(['auth'])->name('formations.mes-inscriptions');
    Route::get('/inscription/{inscription}/document/{type}', [FormationController::class, 'downloadDocument'])
        ->middleware(['auth'])
        ->name('formation.document.download');
    Route::get('/{formation}/flyer', [FormationController::class, 'downloadFlyer'])->name('formation.flyer.download');
    Route::get('/inscription/{inscription}/finaliser', [FormationController::class, 'finaliserInscription'])
        ->middleware(['auth'])
        ->name('formation.finaliser-inscription');
    Route::post('/inscription/{inscription}/soumettre-documents', [FormationController::class, 'soumettreDocuments'])
        ->middleware(['auth'])
        ->name('formation.soumettre-documents');
});

// Routes d'administration
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Route du tableau de bord admin
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])
        ->name('dashboard');
    
    // Routes pour les notifications
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::put('/{id}/read', [NotificationController::class, 'markAsRead'])->name('read');
        Route::post('/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('markAllAsRead');
        Route::delete('/{id}', [NotificationController::class, 'destroy'])->name('destroy');
        Route::delete('/', [NotificationController::class, 'destroyAll'])->name('destroyAll');
    });

    // Routes pour les formations et inscriptions
    Route::prefix('formations')->group(function () {
        // Routes pour les inscriptions aux formations
        Route::get('/inscriptions', [AdminFormationController::class, 'inscriptions'])->name('formations.inscriptions.index');
        Route::prefix('inscriptions')->group(function () {
            Route::get('/{inscription}', [FormationInscriptionController::class, 'show'])->name('formations.inscriptions.show');
            Route::put('/{inscription}/status', [FormationInscriptionController::class, 'updateStatus'])->name('formations.inscriptions.status');
            Route::delete('/{inscription}', [FormationInscriptionController::class, 'destroy'])->name('formations.inscriptions.destroy');
            Route::get('/{inscription}/document/{type}', [FormationInscriptionController::class, 'downloadDocument'])->name('formations.inscriptions.document.download');
        });

        // Routes principales des formations
        Route::get('/', [AdminFormationController::class, 'index'])->name('formations.index');
        Route::get('/create', [AdminFormationController::class, 'create'])->name('formations.create');
        Route::post('/', [AdminFormationController::class, 'store'])->name('formations.store');
        Route::get('/{formation}', [AdminFormationController::class, 'show'])->name('formations.show');
        Route::get('/{formation}/edit', [AdminFormationController::class, 'edit'])->name('formations.edit');
        Route::put('/{formation}', [AdminFormationController::class, 'update'])->name('formations.update');
        Route::delete('/{formation}', [AdminFormationController::class, 'destroy'])->name('formations.destroy');
        Route::get('/{formation}/flyer', [AdminFormationController::class, 'downloadFlyer'])->name('formations.flyer.download');
    });

    // Routes pour le monitoring des services IA
    Route::get('/services/status', [App\Http\Controllers\Admin\ServiceStatusController::class, 'index'])
        ->name('services.status');
    Route::post('/services/reset-fallback', [App\Http\Controllers\Admin\ServiceStatusController::class, 'resetFallbackMode'])
        ->name('services.reset-fallback');
    Route::post('/services/reset-quota', [App\Http\Controllers\Admin\ServiceStatusController::class, 'resetQuotaCount'])
        ->name('services.reset-quota');

    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::get('formations/{formation}/flyer', [AdminFormationController::class, 'downloadFlyer'])->name('formations.flyer.download');
    Route::resource('formations', AdminFormationController::class);
    Route::resource('installations', InstallationController::class);
    Route::get('installations/pending', [InstallationController::class, 'pending'])->name('installations.pending');
});

// Routes protégées par authentification
Route::middleware(['auth'])->group(function () {
    // Route du tableau de bord client
    Route::get('/dashboard', [App\Http\Controllers\Client\DashboardController::class, 'index'])
        ->middleware(['client'])
        ->name('dashboard');

    Route::get('/performances-regionales', [RegionalPerformanceController::class, 'index'])->name('performances.regionales');
    Route::get('/api/performances-regionales/data', [RegionalPerformanceController::class, 'getData'])->name('performances.regionales.data');

    // Routes pour le profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Routes pour les activités
    Route::get('/activites', [LogActiviteController::class, 'index'])->name('activites.index');
    
    // Routes pour la maintenance
    Route::prefix('maintenance')->group(function () {
        Route::get('/predictive', [MaintenanceController::class, 'index'])->name('maintenance-predictive');
        Route::post('/', [MaintenanceController::class, 'store'])->name('maintenance.store');
        Route::get('/{id}/edit', [MaintenanceController::class, 'edit'])->name('maintenance.edit');
        Route::put('/{id}', [MaintenanceController::class, 'update'])->name('maintenance.update');
    });

    // Routes pour les paramètres
    Route::get('/parametres', [App\Http\Controllers\SettingsController::class, 'index'])->name('settings.index');
    Route::put('/parametres/update', [App\Http\Controllers\SettingsController::class, 'update'])->name('settings.update');
    Route::put('/parametres/security', [App\Http\Controllers\SettingsController::class, 'security'])->name('settings.security');
    Route::put('/parametres/display', [App\Http\Controllers\SettingsController::class, 'display'])->name('settings.display');
    Route::post('/parametres/2fa', [App\Http\Controllers\SettingsController::class, 'toggleTwoFactor'])->name('settings.2fa');

    // Routes pour les dimensionnements
    Route::get('/dimensionnements', [DimensionnementController::class, 'index'])->name('dimensionnements.index');
    Route::get('/dimensionnements/create', [DimensionnementController::class, 'create'])->name('dimensionnements.create');
    Route::post('/dimensionnements', [DimensionnementController::class, 'store'])->name('dimensionnements.store');
    Route::get('/dimensionnements/{dimensionnement}', [DimensionnementController::class, 'show'])->name('dimensionnements.show');
});

// Routes des services
Route::middleware(['auth'])->group(function () {
    Route::get('/suivi-production', [SuiviProductionController::class, 'index'])->name('suivi-production');
    Route::get('/maintenance', [MaintenanceController::class, 'index'])->name('maintenance');
    Route::get('/optimisation', [OptimisationController::class, 'index'])->name('optimisation');
    Route::get('/support', [SupportController::class, 'index'])->name('support');

    // Nouvelles routes pour les fonctionnalités
    Route::get('/previsions-meteo', [MeteoController::class, 'index'])->name('previsions-meteo');
    Route::get('/rapports-analyses', [RapportController::class, 'index'])->name('rapports-analyses');
    Route::get('/rapports/export-pdf', [RapportController::class, 'exportPDF'])->name('rapports.export-pdf');
    Route::get('/rapports/export-excel', [RapportController::class, 'exportExcel'])->name('rapports.export-excel');
});

// Routes pour le blog
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/blog/search', [BlogController::class, 'search'])->name('blog.search');
Route::get('/blog/category/{slug}', [BlogController::class, 'category'])->name('blog.category');
Route::get('/blog/tag/{slug}', [BlogController::class, 'tag'])->name('blog.tag');
Route::get('/blog/author/{id}', [BlogController::class, 'author'])->name('blog.author');

// Routes pour les pages statiques
Route::get('/about', function () {
    return view('about');
})->name('about');

// Routes pour le contact
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Routes pour les techniciens
Route::middleware(['auth', 'role:technician'])->prefix('technician')->name('technician.')->group(function () {
    Route::get('installations', [TechnicianController::class, 'installations'])->name('installations');
    Route::get('maintenance', [TechnicianController::class, 'maintenance'])->name('maintenance');
});

Route::get('/technician/form', [TechnicianController::class, 'showForm'])->name('technician.form');
Route::post('/technician/form', [TechnicianController::class, 'submitForm'])->name('technician.form.submit');
Route::post('/technician/submit', [TechnicianController::class, 'submit'])->name('technician.submit');

// Routes pour le suivi de production
Route::get('/suivi-production', [SuiviProductionController::class, 'index'])->name('suivi-production');
Route::get('/suivi-production/data', [SuiviProductionController::class, 'getData'])->name('suivi-production.data');
Route::get('/suivi-production/export-pdf', [SuiviProductionController::class, 'exportPDF'])->name('suivi-production.export-pdf');
Route::get('/suivi-production/export-csv', [SuiviProductionController::class, 'exportCSV'])->name('suivi-production.export-csv');

// Routes pour la page de santé
Route::get('/healthz', function() {
    return response('OK', 200);
});

require __DIR__.'/auth.php';

// Téléchargement des documents optionnels d'inscription formation
Route::get('/admin/formations/inscriptions/{inscription}/autre-document/{index}', [App\Http\Controllers\FormationController::class, 'downloadAutreDocument'])->name('admin.formations.inscriptions.autre-document.download');
