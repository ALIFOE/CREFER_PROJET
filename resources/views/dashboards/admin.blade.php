@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-50 py-8 px-4">
    <div class="max-w-7xl mx-auto">
        <!-- Header Welcome -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900">Tableau de Bord Administrateur</h1>
                    <p class="text-gray-600 mt-2">Bienvenue {{ auth()->user()->name }} - Supervisez la plateforme</p>
                </div>
                <div class="text-6xl opacity-10">
                    <i class="fas fa-cogs"></i>
                </div>
            </div>
        </div>

        <!-- Key Metrics -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Utilisateurs -->
            <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-1"></div>
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Total Utilisateurs</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalUtilisateurs ?? 0 }}</p>
                        </div>
                        <div class="bg-blue-100 rounded-full p-4">
                            <i class="fas fa-users text-2xl text-blue-600"></i>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-4">↑ 12% ce mois</p>
                </div>
            </div>

            <!-- Total Formations -->
            <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow overflow-hidden">
                <div class="bg-gradient-to-r from-purple-500 to-purple-600 h-1"></div>
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Formations</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalFormations ?? 0 }}</p>
                        </div>
                        <div class="bg-purple-100 rounded-full p-4">
                            <i class="fas fa-book text-2xl text-purple-600"></i>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-4">{{ $formationsActives ?? 0 }} actives</p>
                </div>
            </div>

            <!-- Total Inscriptions -->
            <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow overflow-hidden">
                <div class="bg-gradient-to-r from-green-500 to-green-600 h-1"></div>
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Inscriptions</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalInscriptions ?? 0 }}</p>
                        </div>
                        <div class="bg-green-100 rounded-full p-4">
                            <i class="fas fa-user-check text-2xl text-green-600"></i>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-4">+24 cette semaine</p>
                </div>
            </div>

            <!-- Taux Satisfaction -->
            <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow overflow-hidden">
                <div class="bg-gradient-to-r from-orange-500 to-orange-600 h-1"></div>
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Satisfaction</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $tauxSatisfaction ?? 0 }}%</p>
                        </div>
                        <div class="bg-orange-100 rounded-full p-4">
                            <i class="fas fa-star text-2xl text-orange-600"></i>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-4">Basé sur les avis</p>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Croissance Utilisateurs -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-6">Croissance des Utilisateurs</h2>
                <canvas id="utilisateursChart" class="w-full h-80"></canvas>
            </div>

            <!-- Distribution Formations -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-6">Distribution des Formations</h2>
                <canvas id="formationsChart" class="w-full h-80"></canvas>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column (2/3) -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Inscriptions Récentes -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-lg font-bold text-gray-900">Inscriptions Récentes</h2>
                        <a href="#" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">Voir tout</a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-gray-200">
                                    <th class="text-left py-3 px-4 text-gray-700 font-medium">Étudiant</th>
                                    <th class="text-left py-3 px-4 text-gray-700 font-medium">Formation</th>
                                    <th class="text-left py-3 px-4 text-gray-700 font-medium">Date</th>
                                    <th class="text-left py-3 px-4 text-gray-700 font-medium">Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-gray-100 hover:bg-gray-50">
                                    <td class="py-3 px-4">Jean Dupont</td>
                                    <td class="py-3 px-4">Python Avancé</td>
                                    <td class="py-3 px-4">2025-01-15</td>
                                    <td class="py-3 px-4">
                                        <span class="inline-block bg-green-100 text-green-800 text-xs px-2 py-1 rounded">Approuvée</span>
                                    </td>
                                </tr>
                                <tr class="border-b border-gray-100 hover:bg-gray-50">
                                    <td class="py-3 px-4">Marie Martin</td>
                                    <td class="py-3 px-4">Web Development</td>
                                    <td class="py-3 px-4">2025-01-14</td>
                                    <td class="py-3 px-4">
                                        <span class="inline-block bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded">En attente</span>
                                    </td>
                                </tr>
                                <tr class="border-b border-gray-100 hover:bg-gray-50">
                                    <td class="py-3 px-4">Pierre Bernard</td>
                                    <td class="py-3 px-4">Data Science</td>
                                    <td class="py-3 px-4">2025-01-13</td>
                                    <td class="py-3 px-4">
                                        <span class="inline-block bg-green-100 text-green-800 text-xs px-2 py-1 rounded">Approuvée</span>
                                    </td>
                                </tr>
                                <tr class="border-b border-gray-100 hover:bg-gray-50">
                                    <td class="py-3 px-4">Sophie Laurent</td>
                                    <td class="py-3 px-4">Mobile Development</td>
                                    <td class="py-3 px-4">2025-01-12</td>
                                    <td class="py-3 px-4">
                                        <span class="inline-block bg-red-100 text-red-800 text-xs px-2 py-1 rounded">Rejetée</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Activité Système -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-6">Activité Système</h2>
                    <canvas id="activiteChart" class="w-full h-80"></canvas>
                </div>
            </div>

            <!-- Right Column (1/3) -->
            <div class="space-y-8">
                <!-- Actions Administrateur -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Gestion</h2>
                    <div class="space-y-3">
                        <a href="#" class="block w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg text-center transition text-sm">
                            <i class="fas fa-user-plus mr-2"></i> Ajouter Utilisateur
                        </a>
                        <a href="#" class="block w-full bg-purple-600 hover:bg-purple-700 text-white font-medium py-2 px-4 rounded-lg text-center transition text-sm">
                            <i class="fas fa-book-plus mr-2"></i> Créer Formation
                        </a>
                        <a href="#" class="block w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg text-center transition text-sm">
                            <i class="fas fa-file-export mr-2"></i> Exporter Données
                        </a>
                        <a href="#" class="block w-full bg-orange-600 hover:bg-orange-700 text-white font-medium py-2 px-4 rounded-lg text-center transition text-sm">
                            <i class="fas fa-cog mr-2"></i> Paramètres
                        </a>
                    </div>
                </div>

                <!-- Alertes Importantes -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Alertes</h2>
                    <div class="space-y-3">
                        <div class="flex items-start gap-3 p-3 bg-red-50 rounded-lg border border-red-200">
                            <div class="text-red-600 mt-1">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-red-900">3 formations sans enseignant</p>
                                <p class="text-xs text-red-700">Action requise</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3 p-3 bg-yellow-50 rounded-lg border border-yellow-200">
                            <div class="text-yellow-600 mt-1">
                                <i class="fas fa-bell"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-yellow-900">5 inscriptions en attente</p>
                                <p class="text-xs text-yellow-700">À approuver</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3 p-3 bg-blue-50 rounded-lg border border-blue-200">
                            <div class="text-blue-600 mt-1">
                                <i class="fas fa-info-circle"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-blue-900">Backup système</p>
                                <p class="text-xs text-blue-700">Demain à 02:00</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistiques Serveur -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Serveur</h2>
                    <div class="space-y-3">
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm text-gray-600">CPU</span>
                                <span class="text-sm font-bold text-gray-900">65%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-orange-500 h-2 rounded-full" style="width: 65%"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm text-gray-600">Mémoire</span>
                                <span class="text-sm font-bold text-gray-900">42%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-500 h-2 rounded-full" style="width: 42%"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm text-gray-600">Stockage</span>
                                <span class="text-sm font-bold text-gray-900">78%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-red-500 h-2 rounded-full" style="width: 78%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Graphique Croissance Utilisateurs
        const utilisateursCtx = document.getElementById('utilisateursChart');
        if (utilisateursCtx) {
            new Chart(utilisateursCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin'],
                    datasets: [{
                        label: 'Nouveaux Utilisateurs',
                        data: [120, 150, 180, 210, 250, 300],
                        borderColor: 'rgb(59, 130, 246)',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        tension: 0.4,
                        fill: true,
                        pointRadius: 6,
                        pointBackgroundColor: 'rgb(59, 130, 246)',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        // Graphique Distribution Formations
        const formationsCtx = document.getElementById('formationsChart');
        if (formationsCtx) {
            new Chart(formationsCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Python', 'Web Dev', 'Data Science', 'Mobile', 'Cloud'],
                    datasets: [{
                        data: [25, 30, 20, 15, 10],
                        backgroundColor: [
                            'rgba(99, 102, 241, 0.8)',
                            'rgba(59, 130, 246, 0.8)',
                            'rgba(16, 185, 129, 0.8)',
                            'rgba(245, 158, 11, 0.8)',
                            'rgba(168, 85, 247, 0.8)'
                        ],
                        borderColor: '#fff',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }

        // Graphique Activité
        const activiteCtx = document.getElementById('activiteChart');
        if (activiteCtx) {
            new Chart(activiteCtx, {
                type: 'bar',
                data: {
                    labels: ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'],
                    datasets: [
                        {
                            label: 'Connexions',
                            data: [120, 180, 150, 220, 190, 100, 80],
                            backgroundColor: 'rgba(99, 102, 241, 0.8)',
                            borderRadius: 8
                        },
                        {
                            label: 'Inscriptions',
                            data: [30, 45, 35, 50, 40, 20, 15],
                            backgroundColor: 'rgba(16, 185, 129, 0.8)',
                            borderRadius: 8
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    });
</script>
@endsection
