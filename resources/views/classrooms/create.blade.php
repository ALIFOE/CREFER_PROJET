@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-md">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Ajouter une Salle</h1>

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('classrooms.store') }}" class="bg-white shadow rounded-lg p-6">
        @csrf
        
        <div class="mb-4">
            <label for="room_number" class="block text-gray-700 font-bold mb-2">Numéro de salle</label>
            <input type="text" name="room_number" id="room_number" class="w-full border border-gray-300 rounded px-3 py-2" required value="{{ old('room_number') }}">
        </div>

        <div class="mb-4">
            <label for="building" class="block text-gray-700 font-bold mb-2">Bâtiment</label>
            <input type="text" name="building" id="building" class="w-full border border-gray-300 rounded px-3 py-2" required value="{{ old('building') }}">
        </div>

        <div class="mb-6">
            <label for="capacity" class="block text-gray-700 font-bold mb-2">Capacité</label>
            <input type="number" name="capacity" id="capacity" class="w-full border border-gray-300 rounded px-3 py-2" required min="1" value="{{ old('capacity') }}">
        </div>

        <div class="flex gap-4">
            <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Créer</button>
            <a href="{{ route('classrooms.index') }}" class="flex-1 bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-4 rounded text-center">Annuler</a>
        </div>
    </form>
</div>
@endsection
