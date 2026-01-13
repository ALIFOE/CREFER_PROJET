<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\Client\DashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Client\InstallationController;
use App\Http\Controllers\Client\RealtimeDataController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\LogActiviteController;
use App\Http\Controllers\TechnicianController;
use App\Http\Controllers\RapportController;
use App\Http\Controllers\RegionalPerformanceController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\OptimisationController;
use App\Http\Controllers\SupportController;

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

// Redirection de /login vers /
Route::redirect('/login', '/', 301);

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

    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::resource('installations', InstallationController::class);
    Route::get('installations/pending', [InstallationController::class, 'pending'])->name('installations.pending');
});

// Routes protégées par authentification
Route::middleware(['auth'])->group(function () {
    // Route du tableau de bord client
    Route::get('/dashboard', [App\Http\Controllers\Client\DashboardController::class, 'index'])
        ->middleware(['enseignant'])
        ->name('dashboard');

    Route::get('/performances-regionales', [RegionalPerformanceController::class, 'index'])->name('performances.regionales');
    Route::get('/api/performances-regionales/data', [RegionalPerformanceController::class, 'getData'])->name('performances.regionales.data');

    // Routes pour le profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Routes pour les activités
    Route::get('/activites', [LogActiviteController::class, 'index'])->name('activites.index');
    
    // Routes pour les paramètres
    Route::get('/parametres', [App\Http\Controllers\SettingsController::class, 'index'])->name('settings.index');
    Route::put('/parametres/update', [App\Http\Controllers\SettingsController::class, 'update'])->name('settings.update');
    Route::put('/parametres/security', [App\Http\Controllers\SettingsController::class, 'security'])->name('settings.security');
    Route::put('/parametres/display', [App\Http\Controllers\SettingsController::class, 'display'])->name('settings.display');
    Route::post('/parametres/2fa', [App\Http\Controllers\SettingsController::class, 'toggleTwoFactor'])->name('settings.2fa');

    // Routes pour les dimensionnements
   

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

// ========================
// Routes pour le système de gestion scolaire
// ========================

Route::middleware(['auth', 'verified'])->group(function () {
    // Routes pour les étudiants
    Route::resource('students', 'App\Http\Controllers\StudentController');
    
    // Routes pour les professeurs
    Route::resource('professors', 'App\Http\Controllers\ProfessorController');
    
    // Routes pour les salles de classe
    Route::resource('classrooms', 'App\Http\Controllers\ClassroomController');
    
    // Routes pour les cours
    Route::resource('courses', 'App\Http\Controllers\CourseController');
    
    // Routes pour les inscriptions
    Route::resource('enrollments', 'App\Http\Controllers\EnrollmentController');
    
    // Routes pour les présences
    Route::resource('attendances', 'App\Http\Controllers\AttendanceController');
});