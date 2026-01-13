@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Détails de l'Étudiant</h1>
        <a href="{{ route('students.index') }}" class="bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-4 rounded">Retour</a>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-gray-600 font-semibold">Prénom</p>
                <p class="text-gray-900">{{ $student->firstname }}</p>
            </div>
            <div>
                <p class="text-gray-600 font-semibold">Nom</p>
                <p class="text-gray-900">{{ $student->lastname }}</p>
            </div>
            <div>
                <p class="text-gray-600 font-semibold">Email</p>
                <p class="text-gray-900">{{ $student->email }}</p>
            </div>
            <div>
                <p class="text-gray-600 font-semibold">Téléphone</p>
                <p class="text-gray-900">{{ $student->phone ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-gray-600 font-semibold">Date de naissance</p>
                <p class="text-gray-900">{{ $student->date_of_birth ? $student->date_of_birth->format('d/m/Y') : 'N/A' }}</p>
            </div>
            <div>
                <p class="text-gray-600 font-semibold">Adresse</p>
                <p class="text-gray-900">{{ $student->address ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-gray-600 font-semibold">Date d'inscription</p>
                <p class="text-gray-900">{{ $student->enrollment_date->format('d/m/Y') }}</p>
            </div>
            <div>
                <p class="text-gray-600 font-semibold">Statut</p>
                <span class="px-2 py-1 rounded-full text-xs font-medium
                    @if($student->status === 'active') bg-green-100 text-green-800
                    @elseif($student->status === 'inactive') bg-gray-100 text-gray-800
                    @else bg-red-100 text-red-800
                    @endif">
                    {{ $student->status }}
                </span>
            </div>
        </div>

        <div class="mt-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Cours inscrits</h2>
            @if($student->courses->count())
                <div class="grid grid-cols-1 gap-4">
                    @foreach($student->courses as $course)
                    <div class="border border-gray-300 rounded p-4">
                        <p class="font-semibold">{{ $course->course_name }}</p>
                        <p class="text-gray-600">Code: {{ $course->course_code }}</p>
                        <p class="text-gray-600">Professeur: {{ $course->professor->firstname }} {{ $course->professor->lastname }}</p>
                    </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-600">Pas de cours inscrits</p>
            @endif
        </div>

        <div class="mt-6 flex gap-4">
            <a href="{{ route('students.edit', $student->student_id) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">Modifier</a>
            <form method="POST" action="{{ route('students.destroy', $student->student_id) }}" class="inline">
                @csrf @method('DELETE')
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Êtes-vous sûr ?')">Supprimer</button>
            </form>
        </div>
    </div>
</div>
@endsection
