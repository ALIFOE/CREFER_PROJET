<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'CREFER') }} - Connexion</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gradient-to-br from-blue-50 via-purple-50 to-pink-50">
        <div class="min-h-screen flex items-center justify-center py-12 px-4">
            <div class="w-full max-w-4xl">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-stretch">
                    <!-- Colonne Gauche - Formulaire -->
                    <div class="bg-white rounded-lg shadow-lg p-8">
                        <!-- Logo -->
                        <div class="flex justify-center mb-6">
                            <img src="{{ asset('images/logo-crefer.png') }}" alt="Logo CREFER" class="h-14 w-auto">
                        </div>

                        <h1 class="text-3xl font-bold text-center text-gray-800 mb-2">CREFER</h1>
                        <p class="text-center text-gray-500 text-sm mb-8">Plateforme de gestion des formations</p>

                        <!-- Session Status -->
                        @if ($errors->any())
                            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                                <p class="text-red-800 text-sm font-medium">{{ $errors->first() }}</p>
                            </div>
                        @endif

                        <!-- Formulaire Unifié -->
                        <form method="POST" action="{{ route('login') }}" class="space-y-6">
                            @csrf

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <input type="email" 
                                    id="email" 
                                    name="email" 
                                    value="{{ old('email') }}"
                                    required 
                                    autofocus
                                    autocomplete="username"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror"
                                    placeholder="votre@email.com">
                                @error('email')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Mot de passe -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Mot de passe</label>
                                <input type="password" 
                                    id="password" 
                                    name="password" 
                                    required
                                    autocomplete="current-password"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror"
                                    placeholder="••••••••">
                                @error('password')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Se souvenir de moi -->
                            <div class="flex items-center">
                                <input type="checkbox" 
                                    id="remember" 
                                    name="remember"
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="remember" class="ml-2 block text-sm text-gray-700">
                                    Se souvenir de moi
                                </label>
                            </div>

                            <!-- Bouton de connexion -->
                            <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-3 rounded-lg transition duration-300 flex items-center justify-center gap-2">
                                <i class="fas fa-sign-in-alt"></i>
                                Se connecter
                            </button>

                            <!-- Liens supplémentaires -->
                            <div class="flex flex-col gap-3 pt-4 border-t border-gray-200">
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-center text-sm text-blue-600 hover:text-blue-800 transition">
                                        Mot de passe oublié ?
                                    </a>
                                @endif
                                <a href="{{ route('register') }}" class="text-center text-sm text-blue-600 hover:text-blue-800 transition">
                                    Pas encore inscrit ? S'inscrire
                                </a>
                            </div>
                        </form>

                        <!-- Note d'information -->
                        <div class="mt-8 p-4 bg-blue-50 border-l-4 border-blue-500 rounded">
                            <p class="text-xs text-blue-800">
                                <i class="fas fa-lightbulb mr-2"></i>
                                <strong>Connexion Unifiée:</strong> Un seul formulaire pour tous les rôles. Le système détecte automatiquement votre rôle (Admin, Professeur, Étudiant) et vous redirige vers votre espace personnel.
                            </p>
                        </div>
                    </div>

                    <!-- Colonne Droite - Information Visuelle -->
                    <div class="hidden lg:flex flex-col justify-between">
                        <!-- Admin -->
                        <div class="bg-gradient-to-br from-red-400 to-pink-500 rounded-lg shadow-lg p-8 text-white">
                            <div class="text-5xl mb-4"><i class="fas fa-shield-alt"></i></div>
                            <h3 class="text-2xl font-bold mb-2">Administrateurs</h3>
                            <p class="text-red-50 text-sm">Contrôlez et supervisez toute la plateforme</p>
                        </div>

                        <!-- Professeur -->
                        <div class="bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg shadow-lg p-8 text-white">
                            <div class="text-5xl mb-4"><i class="fas fa-chalkboard-user"></i></div>
                            <h3 class="text-2xl font-bold mb-2">Enseignants</h3>
                            <p class="text-blue-50 text-sm">Gérez vos formations et suivez vos étudiants</p>
                        </div>

                        <!-- Étudiant -->
                        <div class="bg-gradient-to-br from-green-400 to-emerald-500 rounded-lg shadow-lg p-8 text-white">
                            <div class="text-5xl mb-4"><i class="fas fa-graduation-cap"></i></div>
                            <h3 class="text-2xl font-bold mb-2">Étudiants</h3>
                            <p class="text-green-50 text-sm">Accédez à vos cours et suivez votre progression</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
