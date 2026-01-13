@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Enregistrer une Présence</h1>

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('attendances.store') }}" class="bg-white shadow rounded-lg p-6">
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
            <label for="attendance_date" class="block text-gray-700 font-bold mb-2">Date</label>
            <input type="date" name="attendance_date" id="attendance_date" class="w-full border border-gray-300 rounded px-3 py-2" required value="{{ old('attendance_date', now()->format('Y-m-d')) }}">
        </div>

        <div class="mb-4">
            <label for="status" class="block text-gray-700 font-bold mb-2">Statut</label>
            <select name="status" id="status" class="w-full border border-gray-300 rounded px-3 py-2" required>
                <option value="">Sélectionnez un statut</option>
                <option value="present" {{ old('status') === 'present' ? 'selected' : '' }}>Présent</option>
                <option value="absent" {{ old('status') === 'absent' ? 'selected' : '' }}>Absent</option>
                <option value="excused" {{ old('status') === 'excused' ? 'selected' : '' }}>Excusé</option>
            </select>
        </div>

        <div class="mb-6">
            <label for="remarks" class="block text-gray-700 font-bold mb-2">Remarques</label>
            <textarea name="remarks" id="remarks" class="w-full border border-gray-300 rounded px-3 py-2" rows="3">{{ old('remarks') }}</textarea>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Enregistrer</button>
            <a href="{{ route('attendances.index') }}" class="flex-1 bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-4 rounded text-center">Annuler</a>
        </div>
    </form>
</div>
@endsection
