@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-md">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Ajouter un Professeur</h1>

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('professors.store') }}" class="bg-white shadow rounded-lg p-6">
        @csrf
        
        <div class="mb-4">
            <label for="firstname" class="block text-gray-700 font-bold mb-2">Prénom</label>
            <input type="text" name="firstname" id="firstname" class="w-full border border-gray-300 rounded px-3 py-2" required value="{{ old('firstname') }}">
        </div>

        <div class="mb-4">
            <label for="lastname" class="block text-gray-700 font-bold mb-2">Nom</label>
            <input type="text" name="lastname" id="lastname" class="w-full border border-gray-300 rounded px-3 py-2" required value="{{ old('lastname') }}">
        </div>

        <div class="mb-4">
            <label for="email" class="block text-gray-700 font-bold mb-2">Email</label>
            <input type="email" name="email" id="email" class="w-full border border-gray-300 rounded px-3 py-2" required value="{{ old('email') }}">
        </div>

        <div class="mb-4">
            <label for="phone" class="block text-gray-700 font-bold mb-2">Téléphone</label>
            <input type="text" name="phone" id="phone" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ old('phone') }}">
        </div>

        <div class="mb-4">
            <label for="specialization" class="block text-gray-700 font-bold mb-2">Spécialisation</label>
            <input type="text" name="specialization" id="specialization" class="w-full border border-gray-300 rounded px-3 py-2" required value="{{ old('specialization') }}">
        </div>

        <div class="mb-4">
            <label for="hire_date" class="block text-gray-700 font-bold mb-2">Date d'embauche</label>
            <input type="date" name="hire_date" id="hire_date" class="w-full border border-gray-300 rounded px-3 py-2" required value="{{ old('hire_date', now()->format('Y-m-d')) }}">
        </div>

        <div class="mb-6">
            <label for="status" class="block text-gray-700 font-bold mb-2">Statut</label>
            <select name="status" id="status" class="w-full border border-gray-300 rounded px-3 py-2" required>
                <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Actif</option>
                <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactif</option>
                <option value="on_leave" {{ old('status') === 'on_leave' ? 'selected' : '' }}>En congé</option>
            </select>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Créer</button>
            <a href="{{ route('professors.index') }}" class="flex-1 bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-4 rounded text-center">Annuler</a>
        </div>
    </form>
</div>
@endsection
