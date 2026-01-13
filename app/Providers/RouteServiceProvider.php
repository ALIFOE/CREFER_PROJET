<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/dashboard';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        // Bindings implicites pour les modèles avec clés primaires personnalisées
        Route::model('student', \App\Models\Student::class);
        Route::model('professor', \App\Models\Professor::class);
        Route::model('classroom', \App\Models\Classroom::class);
        Route::model('course', \App\Models\Course::class);
        Route::model('enrollment', \App\Models\Enrollment::class);
        Route::model('attendance', \App\Models\Attendance::class);

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            // Routes d'administration
            if (file_exists(base_path('routes/admin.php'))) {
                Route::middleware(['web', 'auth', 'admin'])
                    ->prefix('admin')
                    ->name('admin.')
                    ->group(base_path('routes/admin.php'));
            }
        });

        // Redirection personnalisée après l'authentification
        $this->app['router']->matched(function ($event) {
            $request = $event->request;
            if (auth()->check() && $request->is('dashboard')) {
                $user = auth()->user();
                
                if ($user->role === 'admin') {
                    return redirect()->route('admin.dashboard');
                }
            }
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
