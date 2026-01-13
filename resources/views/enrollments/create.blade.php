@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Ajouter une Inscription</h1>

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('enrollments.store') }}" class="bg-white shadow rounded-lg p-6">
        @csrf
        
        <div class="mb-4">
            <label for="student_id" class="block text-gray-700 font-bold mb-2">Étudiant</label>
            <select name="student_id" id="student_id" class="w-full border border-gray-300 rounded px-3 py-2" required>
                <option value="">Sélectionnez un étudiant</option>
                @foreach($students as $student)
                <option value="{{ $student->student_id }}" {{ old('student_id') == $student->student_id ? 'selected' : '' }}>
                    {{ $student->firstname }} {{ $student->lastname }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="course_id" class="block text-gray-700 font-bold mb-2">Cours</label>
            <select name="course_id" id="course_id" class="w-full border border-gray-300 rounded px-3 py-2" required>
                <option value="">Sélectionnez un cours</option>
                @foreach($courses as $course)
                <option value="{{ $course->course_id }}" {{ old('course_id') == $course->course_id ? 'selected' : '' }}>
                    {{ $course->course_name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="enrollment_date" class="block text-gray-700 font-bold mb-2">Date d'inscription</label>
            <input type="date" name="enrollment_date" id="enrollment_date" class="w-full border border-gray-300 rounded px-3 py-2" required value="{{ old('enrollment_date', now()->format('Y-m-d')) }}">
        </div>

        <div class="mb-4">
            <label for="grade" class="block text-gray-700 font-bold mb-2">Note</label>
            <input type="text" name="grade" id="grade" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ old('grade') }}">
        </div>

        <div class="mb-6">
            <label for="attendance_rate" class="block text-gray-700 font-bold mb-2">Taux de présence (%)</label>
            <input type="number" name="attendance_rate" id="attendance_rate" class="w-full border border-gray-300 rounded px-3 py-2" min="0" max="100" value="{{ old('attendance_rate', 0) }}">
        </div>

        <div class="flex gap-4">
            <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Créer</button>
            <a href="{{ route('enrollments.index') }}" class="flex-1 bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-4 rounded text-center">Annuler</a>
        </div>
    </form>
</div>
@endsection
