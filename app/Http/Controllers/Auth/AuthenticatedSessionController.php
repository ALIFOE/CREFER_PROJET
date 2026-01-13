<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('home');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Rediriger selon le rôle de l'utilisateur détecté automatiquement
        $user = Auth::user();
        
        return match($user->role) {
            'admin' => redirect()->intended('/admin/dashboard'),
            'professor' => redirect()->intended('/professor/dashboard'),
            'student' => redirect()->intended('/student/dashboard'),
            default => redirect()->intended(RouteServiceProvider::HOME)
        };
    }

    /**
     * Destroy an authenticated session.
     */    public function destroy(Request $request): RedirectResponse
    {
        if (!$request->hasSession() || !$request->session()->isStarted()) {
            $request->session()->start();
        }
        
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
