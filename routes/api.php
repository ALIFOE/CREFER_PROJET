<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DevisIAController;
use App\Http\Controllers\DimensionnementIAController;
use App\Http\Controllers\AnalyseProductionIAController;
use App\Http\Controllers\MeteoIAController;
use App\Http\Controllers\RealtimeDataController;
use App\Http\Controllers\Admin\RealtimeProductionController;

// Routes IA avec authentification API
Route::middleware('api.auth')->group(function () {
    Route::post('/devis-ia', [DevisIAController::class, 'generate']);
    Route::post('/dimensionnement-ia', [DimensionnementIAController::class, 'calculer']);
    Route::post('/analyse-production-ia', [AnalyseProductionIAController::class, 'analyser']);
    Route::post('/meteo-ia', [MeteoIAController::class, 'prevoir']);
});



Route::middleware('auth:sanctum')->group(function () {
    // Routes pour les données de performance
    Route::get('/regional-performance', 'App\Http\Controllers\Api\PerformanceController@getRegionalData');
    Route::get('/inverter-status', 'App\Http\Controllers\Api\PerformanceController@getInverterStatus');

    // Routes pour le système intelligent
    Route::get('/alertes', 'App\Http\Controllers\Api\SystemeIntelligentController@getAlertes');
    Route::get('/diagnostic', 'App\Http\Controllers\Api\SystemeIntelligentController@getDiagnostic');
    Route::get('/maintenances/next', 'App\Http\Controllers\Api\SystemeIntelligentController@getNextMaintenance');
    Route::get('/recommendations', 'App\Http\Controllers\Api\SystemeIntelligentController@getRecommendations');
    
    // Routes pour les rapports
    Route::get('/reports/download/{type}/{period}', 'App\Http\Controllers\Api\ReportController@download')
        ->where(['type' => 'pdf|excel', 'period' => 'journalier|hebdomadaire|mensuel']);
    Route::post('/reports/preferences', 'App\Http\Controllers\Api\ReportController@savePreferences');

    // Route pour les données de production et consommation en temps réel
    Route::get('/realtime-production', [RealtimeDataController::class, 'production']);
});

Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {
    Route::get('/realtime-production', [RealtimeProductionController::class, 'getData']);
});
