@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-md">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Modifier l'Étudiant</h1>

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('students.update', $student->student_id) }}" class="bg-white shadow rounded-lg p-6">
        @csrf @method('PUT')
        
        <div class="mb-4">
            <label for="firstname" class="block text-gray-700 font-bold mb-2">Prénom</label>
            <input type="text" name="firstname" id="firstname" class="w-full border border-gray-300 rounded px-3 py-2" required value="{{ old('firstname', $student->firstname) }}">
        </div>

        <div class="mb-4">
            <label for="lastname" class="block text-gray-700 font-bold mb-2">Nom</label>
            <input type="text" name="lastname" id="lastname" class="w-full border border-gray-300 rounded px-3 py-2" required value="{{ old('lastname', $student->lastname) }}">
        </div>

        <div class="mb-4">
            <label for="email" class="block text-gray-700 font-bold mb-2">Email</label>
            <input type="email" name="email" id="email" class="w-full border border-gray-300 rounded px-3 py-2" required value="{{ old('email', $student->email) }}">
        </div>

        <div class="mb-4">
            <label for="phone" class="block text-gray-700 font-bold mb-2">Téléphone</label>
            <input type="text" name="phone" id="phone" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ old('phone', $student->phone) }}">
        </div>

        <div class="mb-4">
            <label for="date_of_birth" class="block text-gray-700 font-bold mb-2">Date de naissance</label>
            <input type="date" name="date_of_birth" id="date_of_birth" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ old('date_of_birth', $student->date_of_birth) }}">
        </div>

        <div class="mb-4">
            <label for="address" class="block text-gray-700 font-bold mb-2">Adresse</label>
            <input type="text" name="address" id="address" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ old('address', $student->address) }}">
        </div>

        <div class="mb-4">
            <label for="enrollment_date" class="block text-gray-700 font-bold mb-2">Date d'inscription</label>
            <input type="date" name="enrollment_date" id="enrollment_date" class="w-full border border-gray-300 rounded px-3 py-2" required value="{{ old('enrollment_date', $student->enrollment_date) }}">
        </div>

        <div class="mb-6">
            <label for="status" class="block text-gray-700 font-bold mb-2">Statut</label>
            <select name="status" id="status" class="w-full border border-gray-300 rounded px-3 py-2" required>
                <option value="active" {{ old('status', $student->status) === 'active' ? 'selected' : '' }}>Actif</option>
                <option value="inactive" {{ old('status', $student->status) === 'inactive' ? 'selected' : '' }}>Inactif</option>
                <option value="suspended" {{ old('status', $student->status) === 'suspended' ? 'selected' : '' }}>Suspendu</option>
            </select>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Modifier</button>
            <a href="{{ route('students.index') }}" class="flex-1 bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-4 rounded text-center">Annuler</a>
        </div>
    </form>
</div>
@endsection
