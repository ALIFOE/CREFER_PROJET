@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Modifier le Cours</h1>

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('courses.update', $course->course_id) }}" class="bg-white shadow rounded-lg p-6">
        @csrf @method('PUT')
        
        <div class="mb-4">
            <label for="course_code" class="block text-gray-700 font-bold mb-2">Code du cours</label>
            <input type="text" name="course_code" id="course_code" class="w-full border border-gray-300 rounded px-3 py-2" required value="{{ old('course_code', $course->course_code) }}">
        </div>

        <div class="mb-4">
            <label for="course_name" class="block text-gray-700 font-bold mb-2">Nom du cours</label>
            <input type="text" name="course_name" id="course_name" class="w-full border border-gray-300 rounded px-3 py-2" required value="{{ old('course_name', $course->course_name) }}">
        </div>

        <div class="mb-4">
            <label for="description" class="block text-gray-700 font-bold mb-2">Description</label>
            <textarea name="description" id="description" class="w-full border border-gray-300 rounded px-3 py-2" rows="3">{{ old('description', $course->description) }}</textarea>
        </div>

        <div class="mb-4">
            <label for="credit_hours" class="block text-gray-700 font-bold mb-2">Crédits horaires</label>
            <input type="number" name="credit_hours" id="credit_hours" class="w-full border border-gray-300 rounded px-3 py-2" required min="1" value="{{ old('credit_hours', $course->credit_hours) }}">
        </div>

        <div class="mb-4">
            <label for="professor_id" class="block text-gray-700 font-bold mb-2">Professeur</label>
            <select name="professor_id" id="professor_id" class="w-full border border-gray-300 rounded px-3 py-2" required>
                <option value="">Sélectionnez un professeur</option>
                @foreach($professors as $prof)
                <option value="{{ $prof->professor_id }}" {{ old('professor_id', $course->professor_id) == $prof->professor_id ? 'selected' : '' }}>
                    {{ $prof->firstname }} {{ $prof->lastname }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="classroom_id" class="block text-gray-700 font-bold mb-2">Salle</label>
            <select name="classroom_id" id="classroom_id" class="w-full border border-gray-300 rounded px-3 py-2" required>
                <option value="">Sélectionnez une salle</option>
                @foreach($classrooms as $room)
                <option value="{{ $room->classroom_id }}" {{ old('classroom_id', $course->classroom_id) == $room->classroom_id ? 'selected' : '' }}>
                    {{ $room->room_number }} - {{ $room->building }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="schedule" class="block text-gray-700 font-bold mb-2">Horaire</label>
            <input type="text" name="schedule" id="schedule" class="w-full border border-gray-300 rounded px-3 py-2" required value="{{ old('schedule', $course->schedule) }}" placeholder="ex: Lundi-Mercredi 09:00-11:00">
        </div>

        <div class="mb-4">
            <label for="start_date" class="block text-gray-700 font-bold mb-2">Date de début</label>
            <input type="date" name="start_date" id="start_date" class="w-full border border-gray-300 rounded px-3 py-2" required value="{{ old('start_date', $course->start_date) }}">
        </div>

        <div class="mb-6">
            <label for="end_date" class="block text-gray-700 font-bold mb-2">Date de fin</label>
            <input type="date" name="end_date" id="end_date" class="w-full border border-gray-300 rounded px-3 py-2" required value="{{ old('end_date', $course->end_date) }}">
        </div>

        <div class="flex gap-4">
            <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Modifier</button>
            <a href="{{ route('courses.index') }}" class="flex-1 bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-4 rounded text-center">Annuler</a>
        </div>
    </form>
</div>
@endsection
