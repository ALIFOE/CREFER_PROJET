@extends('layouts.app')

@section('title', 'Tableau de Bord')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header Section -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900">Tableau de Bord</h1>
        <p class="text-gray-600 mt-2">Bienvenue, {{ auth()->user()->first_name ?? auth()->user()->name }}</p>
    </div>

    <!-- Statistics Cards Row -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <!-- Total Students Card -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Total d'Étudiants</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $studentStats['total'] ?? 0 }}</p>
                </div>
                <div class="text-blue-500 text-4xl">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>

        <!-- Active Students Card -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Étudiants Actifs</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $studentStats['active'] ?? 0 }}</p>
                </div>
                <div class="text-green-500 text-4xl">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
        </div>

        <!-- Total Courses Card -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Cours Actifs</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $courseStats['active'] ?? 0 }}</p>
                </div>
                <div class="text-purple-500 text-4xl">
                    <i class="fas fa-book"></i>
                </div>
            </div>
        </div>

        <!-- Completed Courses Card -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-orange-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Cours Terminés</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $courseStats['completed'] ?? 0 }}</p>
                </div>
                <div class="text-orange-500 text-4xl">
                    <i class="fas fa-graduation-cap"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column (2/3 width) -->
        <div class="lg:col-span-2">
            <!-- Recent Courses Section -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-gray-900">Cours Récents</h2>
                    <a href="#" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Voir tout</a>
                </div>

                @if($courses && count($courses) > 0)
                    <div class="space-y-4">
                        @foreach($courses as $course)
                            <div class="border rounded-lg p-4 hover:shadow-md transition">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-gray-900">{{ $course->name ?? 'Cours sans titre' }}</h3>
                                        <p class="text-sm text-gray-600 mt-1">{{ $course->code ?? 'N/A' }}</p>
                                        <p class="text-sm text-gray-500 mt-2">{{ Str::limit($course->description, 100) ?? '' }}</p>
                                        <div class="flex gap-2 mt-3">
                                            <span class="inline-block bg-green-100 text-green-800 text-xs px-2 py-1 rounded">
                                                {{ ucfirst($course->status ?? 'unknown') }}
                                            </span>
                                            @if($course->classroom)
                                                <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">
                                                    {{ $course->classroom->name ?? 'Salle N/A' }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xs text-gray-500">Crédits</p>
                                        <p class="text-2xl font-bold text-gray-900">{{ $course->credits ?? 0 }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <p class="text-gray-500">Aucun cours récent</p>
                    </div>
                @endif
            </div>

            <!-- Course Statistics Section -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Statistiques des Cours</h2>
                
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-4">
                        <p class="text-gray-600 text-sm">Total de Cours</p>
                        <p class="text-2xl font-bold text-blue-900">{{ $courseStats['total'] ?? 0 }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-4">
                        <p class="text-gray-600 text-sm">Cours Actifs</p>
                        <p class="text-2xl font-bold text-green-900">{{ $courseStats['active'] ?? 0 }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-lg p-4">
                        <p class="text-gray-600 text-sm">À Venir</p>
                        <p class="text-2xl font-bold text-yellow-900">{{ $courseStats['upcoming'] ?? 0 }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-4">
                        <p class="text-gray-600 text-sm">Terminés</p>
                        <p class="text-2xl font-bold text-purple-900">{{ $courseStats['completed'] ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column (1/3 width) -->
        <div>
            <!-- Active Students Section -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-gray-900">Étudiants Actifs</h2>
                    <a href="#" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Voir tout</a>
                </div>

                @if($students && count($students) > 0)
                    <div class="space-y-3">
                        @foreach($students as $student)
                            <div class="border rounded-lg p-3 hover:bg-gray-50 transition">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-semibold">
                                        {{ strtoupper(substr($student->first_name ?? '', 0, 1) . substr($student->last_name ?? '', 0, 1)) }}
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-semibold text-gray-900">{{ $student->full_name ?? $student->first_name . ' ' . $student->last_name }}</p>
                                        <p class="text-xs text-gray-500">{{ $student->student_id ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <p class="text-gray-500 text-sm">Aucun étudiant actif</p>
                    </div>
                @endif
            </div>

            <!-- Recent Activities Section -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-gray-900">Activités Récentes</h2>
                    <a href="#" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Voir tout</a>
                </div>

                @if($activites && count($activites) > 0)
                    <div class="space-y-3">
                        @foreach($activites as $activite)
                            <div class="border-l-2 border-blue-500 pl-3 py-2">
                                <p class="text-sm text-gray-700">{{ $activite->description ?? 'Activité' }}</p>
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ $activite->created_at ? $activite->created_at->diffForHumans() : 'N/A' }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <p class="text-gray-500 text-sm">Aucune activité récente</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Actions Section -->
    <div class="mt-8 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg shadow-lg p-8 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold mb-2">Actions Rapides</h2>
                <p class="text-blue-100">Gérez facilement vos étudiants et cours</p>
            </div>
            <div class="flex gap-4">
                <a href="#" class="bg-white text-blue-600 hover:bg-blue-50 px-6 py-3 rounded-lg font-semibold transition">
                    <i class="fas fa-user-plus mr-2"></i>Ajouter un Étudiant
                </a>
                <a href="#" class="bg-blue-700 text-white hover:bg-blue-800 px-6 py-3 rounded-lg font-semibold transition">
                    <i class="fas fa-plus mr-2"></i>Créer un Cours
                </a>
            </div>
        </div>
    </div>
</div>

@push('styles')
    <style>
        .border-l-4 {
            border-left-width: 4px;
        }
    </style>
@endpush
@endsection
