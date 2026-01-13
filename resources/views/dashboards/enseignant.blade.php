@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-purple-50 py-8 px-4">
    <div class="max-w-7xl mx-auto">
        <!-- Header Welcome -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900">Bienvenue, {{ auth()->user()->name }}!</h1>
                    <p class="text-gray-600 mt-2">Tableau de bord enseignant - Gérez vos formations et étudiants</p>
                </div>
                <div class="text-6xl opacity-10">
                    <i class="fas fa-chalkboard-user"></i>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Formation Actives -->
            <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 h-1"></div>
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Formations Actives</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $formationsActives ?? 0 }}</p>
                        </div>
                        <div class="bg-indigo-100 rounded-full p-4">
                            <i class="fas fa-book text-2xl text-indigo-600"></i>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-4">↑ 2 ce mois</p>
                </div>
            </div>

            <!-- Total Étudiants -->
            <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-1"></div>
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Total Étudiants</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalEtudiants ?? 0 }}</p>
                        </div>
                        <div class="bg-blue-100 rounded-full p-4">
                            <i class="fas fa-users text-2xl text-blue-600"></i>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-4">+5 cette semaine</p>
                </div>
            </div>

            <!-- Présences -->
            <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow overflow-hidden">
                <div class="bg-gradient-to-r from-green-500 to-green-600 h-1"></div>
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Taux Présence</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $tauxPresence ?? 0 }}%</p>
                        </div>
                        <div class="bg-green-100 rounded-full p-4">
                            <i class="fas fa-check-circle text-2xl text-green-600"></i>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-4">Excellente participation</p>
                </div>
            </div>

            <!-- Tâches Pendantes -->
            <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow overflow-hidden">
                <div class="bg-gradient-to-r from-orange-500 to-orange-600 h-1"></div>
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Tâches Pendantes</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $tachesPendantes ?? 0 }}</p>
                        </div>
                        <div class="bg-orange-100 rounded-full p-4">
                            <i class="fas fa-tasks text-2xl text-orange-600"></i>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-4">À compléter</p>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column (2/3) -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Mes Formations -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-gray-900">Mes Formations</h2>
                        <a href="#" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">Voir tout</a>
                    </div>

                    <div class="space-y-4">
                        <!-- Formation Card 1 -->
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-900">Formation Python Avancé</h3>
                                    <p class="text-sm text-gray-600 mt-1">Code: PYT-2025-001</p>
                                    <div class="flex items-center gap-4 mt-3">
                                        <span class="inline-flex items-center gap-1 text-sm text-gray-600">
                                            <i class="fas fa-users"></i> 35 étudiants
                                        </span>
                                        <span class="inline-flex items-center gap-1 text-sm text-gray-600">
                                            <i class="fas fa-calendar"></i> 12 semaines
                                        </span>
                                    </div>
                                    <div class="mt-3">
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-indigo-600 h-2 rounded-full" style="width: 65%"></div>
                                        </div>
                                        <p class="text-xs text-gray-600 mt-1">65% complété</p>
                                    </div>
                                </div>
                                <span class="inline-block bg-indigo-100 text-indigo-800 text-xs px-3 py-1 rounded-full font-medium">En cours</span>
                            </div>
                        </div>

                        <!-- Formation Card 2 -->
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-900">Web Development Bootcamp</h3>
                                    <p class="text-sm text-gray-600 mt-1">Code: WEB-2025-002</p>
                                    <div class="flex items-center gap-4 mt-3">
                                        <span class="inline-flex items-center gap-1 text-sm text-gray-600">
                                            <i class="fas fa-users"></i> 28 étudiants
                                        </span>
                                        <span class="inline-flex items-center gap-1 text-sm text-gray-600">
                                            <i class="fas fa-calendar"></i> 8 semaines
                                        </span>
                                    </div>
                                    <div class="mt-3">
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-green-600 h-2 rounded-full" style="width: 100%"></div>
                                        </div>
                                        <p class="text-xs text-gray-600 mt-1">100% complété</p>
                                    </div>
                                </div>
                                <span class="inline-block bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full font-medium">Terminée</span>
                            </div>
                        </div>

                        <!-- Formation Card 3 -->
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-900">Data Science Essentials</h3>
                                    <p class="text-sm text-gray-600 mt-1">Code: DATA-2025-003</p>
                                    <div class="flex items-center gap-4 mt-3">
                                        <span class="inline-flex items-center gap-1 text-sm text-gray-600">
                                            <i class="fas fa-users"></i> 42 étudiants
                                        </span>
                                        <span class="inline-flex items-center gap-1 text-sm text-gray-600">
                                            <i class="fas fa-calendar"></i> 10 semaines
                                        </span>
                                    </div>
                                    <div class="mt-3">
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-orange-600 h-2 rounded-full" style="width: 35%"></div>
                                        </div>
                                        <p class="text-xs text-gray-600 mt-1">35% complété</p>
                                    </div>
                                </div>
                                <span class="inline-block bg-orange-100 text-orange-800 text-xs px-3 py-1 rounded-full font-medium">À commencer</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Performance des Étudiants -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Performance des Étudiants</h2>
                    <canvas id="performanceChart" class="w-full h-80"></canvas>
                </div>
            </div>

            <!-- Right Column (1/3) -->
            <div class="space-y-8">
                <!-- Activités Récentes -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Activités Récentes</h2>
                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <div class="bg-indigo-100 rounded-full p-2 mt-1">
                                <i class="fas fa-user-plus text-indigo-600 text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Nouvel étudiant inscrit</p>
                                <p class="text-xs text-gray-500">il y a 2 heures</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="bg-green-100 rounded-full p-2 mt-1">
                                <i class="fas fa-check text-green-600 text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Devoir soumis</p>
                                <p class="text-xs text-gray-500">il y a 4 heures</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="bg-orange-100 rounded-full p-2 mt-1">
                                <i class="fas fa-comment text-orange-600 text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Nouveau message</p>
                                <p class="text-xs text-gray-500">il y a 1 jour</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="bg-red-100 rounded-full p-2 mt-1">
                                <i class="fas fa-exclamation text-red-600 text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Absence à signaler</p>
                                <p class="text-xs text-gray-500">il y a 1 jour</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions Rapides -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Actions Rapides</h2>
                    <div class="space-y-3">
                        <a href="#" class="block w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg text-center transition">
                            <i class="fas fa-plus mr-2"></i> Créer une Formation
                        </a>
                        <a href="#" class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg text-center transition">
                            <i class="fas fa-file-upload mr-2"></i> Importer des Étudiants
                        </a>
                        <a href="#" class="block w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg text-center transition">
                            <i class="fas fa-chart-bar mr-2"></i> Générer Rapport
                        </a>
                        <a href="#" class="block w-full bg-purple-600 hover:bg-purple-700 text-white font-medium py-2 px-4 rounded-lg text-center transition">
                            <i class="fas fa-envelope mr-2"></i> Envoyer Message
                        </a>
                    </div>
                </div>

                <!-- Statistiques Globales -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Cette Semaine</h2>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Cours Dispensés</span>
                            <span class="font-bold text-gray-900">5</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Devoirs Évalués</span>
                            <span class="font-bold text-gray-900">12</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Messages Reçus</span>
                            <span class="font-bold text-gray-900">8</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Temps d'Enseignement</span>
                            <span class="font-bold text-gray-900">15h</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Graphique Performance des Étudiants
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('performanceChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Python', 'Web Dev', 'Data Science', 'Mobile', 'Cloud'],
                    datasets: [
                        {
                            label: 'Score Moyen',
                            data: [85, 92, 78, 88, 81],
                            backgroundColor: [
                                'rgba(99, 102, 241, 0.8)',
                                'rgba(59, 130, 246, 0.8)',
                                'rgba(16, 185, 129, 0.8)',
                                'rgba(245, 158, 11, 0.8)',
                                'rgba(168, 85, 247, 0.8)'
                            ],
                            borderRadius: 8,
                            borderSkipped: false
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100,
                            ticks: {
                                callback: function(value) {
                                    return value + '%';
                                }
                            }
                        }
                    }
                }
            });
        }
    });
</script>
@endsection
