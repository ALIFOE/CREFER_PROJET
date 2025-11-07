<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Succès !</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-3xl font-bold mb-8 text-center">Finaliser votre inscription</h1>

                    <div class="mb-6">
                        <h2 class="text-xl font-semibold mb-4">Détails de l'inscription</h2>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-gray-600">Formation :</p>
                                <p class="font-medium">{{ $inscription->formation->titre }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Statut :</p>
                                <p class="font-medium">{{ ucfirst($inscription->statut) }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h2 class="text-xl font-semibold mb-4">Documents déjà soumis</h2>
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Acte de naissance</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>CNI</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Diplôme</span>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('formation.soumettre-documents', $inscription->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div>
                            <h2 class="text-xl font-semibold mb-4">Documents supplémentaires</h2>
                            <p class="text-gray-600 mb-4">Vous pouvez ajouter des documents supplémentaires pour compléter votre dossier.</p>
                            
                            <div class="space-y-4">
                                @for ($i = 1; $i <= 3; $i++)
                                    <div class="mb-4">
                                        <label for="documents[]" class="block text-gray-700 font-medium">Document supplémentaire {{ $i }}</label>
                                        <input type="file" name="documents[]" class="w-full border-gray-300 rounded-lg shadow-sm mt-1">
                                        @error('documents.*')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                @endfor
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Soumettre les documents
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
