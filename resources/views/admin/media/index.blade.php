<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Gestion des médias') }}
            </h2>
            <a href="{{ route('admin.media.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Ajouter un média
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="mb-6">
                <form action="{{ route('admin.media.index') }}" method="GET" class="flex gap-4">
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700">Catégorie</label>
                        <select name="category" id="category" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" onchange="this.form.submit()">
                            <option value="">Toutes les catégories</option>
                            @foreach($categories as $value => $label)
                                <option value="{{ $value }}" {{ request('category') == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                        <select name="type" id="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" onchange="this.form.submit()">
                            <option value="">Tous les types</option>
                            <option value="image" {{ request('type') == 'image' ? 'selected' : '' }}>Images</option>
                            <option value="video" {{ request('type') == 'video' ? 'selected' : '' }}>Vidéos</option>
                        </select>
                    </div>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @forelse($media as $item)
                        <div class="relative group">
                            <div class="card bg-white rounded-lg overflow-hidden shadow-md">
                                <div class="relative aspect-w-16 aspect-h-9">
                                    @if($item->type === 'image')
                                        <img src="{{ Storage::url($item->path) }}" 
                                             alt="{{ $item->title }}" 
                                             class="object-cover w-full h-full">
                                    @else
                                        <video class="object-cover w-full h-full" controls>
                                            <source src="{{ Storage::url($item->path) }}" type="video/mp4">
                                            Votre navigateur ne prend pas en charge la lecture de vidéos.
                                        </video>
                                    @endif
                                    @if($item->is_featured)
                                        <span class="absolute top-2 right-2 bg-yellow-400 text-xs text-white px-2 py-1 rounded">
                                            À la une
                                        </span>
                                    @endif
                                </div>
                                <div class="p-4">
                                    <h3 class="text-lg font-semibold text-gray-800">{{ $item->title }}</h3>
                                    <p class="text-sm text-gray-600">{{ $item->description }}</p>
                                </div>
                            </div>
                            <form action="{{ route('admin.media.destroy', $item) }}" method="POST" class="hidden group-hover:block absolute top-2 left-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white text-xs font-bold py-1 px-2 rounded"
                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce média ?')">
                                    Supprimer
                                </button>
                            </form>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-8">
                            <p class="text-gray-500">Aucun média disponible.</p>
                        </div>
                    @endforelse
                </div>

                <div class="mt-8">
                    {{ $media->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>