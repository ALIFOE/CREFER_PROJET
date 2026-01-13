@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Gestion des Salles</h1>
        <a href="{{ route('classrooms.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">+ Ajouter une salle</a>
    </div>

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($classrooms as $classroom)
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">{{ $classroom->room_number }}</h3>
            <p class="text-gray-600 mb-2"><strong>Bâtiment:</strong> {{ $classroom->building }}</p>
            <p class="text-gray-600 mb-4"><strong>Capacité:</strong> {{ $classroom->capacity }} places</p>
            <div class="flex gap-2">
                <a href="{{ route('classrooms.edit', $classroom->classroom_id) }}" class="flex-1 bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded text-center text-sm">Modifier</a>
                <form method="POST" action="{{ route('classrooms.destroy', $classroom->classroom_id) }}" class="flex-1">
                    @csrf @method('DELETE')
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded text-sm" onclick="return confirm('Êtes-vous sûr ?')">Supprimer</button>
                </form>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $classrooms->links() }}
    </div>
</div>
@endsection
