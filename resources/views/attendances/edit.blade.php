@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Modifier la Présence</h1>

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('attendances.update', $attendance->attendance_id) }}" class="bg-white shadow rounded-lg p-6">
        @csrf @method('PUT')
        
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Étudiant</label>
            <p class="text-gray-900">{{ $attendance->student->firstname }} {{ $attendance->student->lastname }}</p>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Cours</label>
            <p class="text-gray-900">{{ $attendance->course->course_name }}</p>
        </div>

        <div class="mb-4">
            <label for="attendance_date" class="block text-gray-700 font-bold mb-2">Date</label>
            <input type="date" name="attendance_date" id="attendance_date" class="w-full border border-gray-300 rounded px-3 py-2" required value="{{ old('attendance_date', $attendance->attendance_date) }}">
        </div>

        <div class="mb-4">
            <label for="status" class="block text-gray-700 font-bold mb-2">Statut</label>
            <select name="status" id="status" class="w-full border border-gray-300 rounded px-3 py-2" required>
                <option value="present" {{ old('status', $attendance->status) === 'present' ? 'selected' : '' }}>Présent</option>
                <option value="absent" {{ old('status', $attendance->status) === 'absent' ? 'selected' : '' }}>Absent</option>
                <option value="excused" {{ old('status', $attendance->status) === 'excused' ? 'selected' : '' }}>Excusé</option>
            </select>
        </div>

        <div class="mb-6">
            <label for="remarks" class="block text-gray-700 font-bold mb-2">Remarques</label>
            <textarea name="remarks" id="remarks" class="w-full border border-gray-300 rounded px-3 py-2" rows="3">{{ old('remarks', $attendance->remarks) }}</textarea>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Modifier</button>
            <a href="{{ route('attendances.index') }}" class="flex-1 bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-4 rounded text-center">Annuler</a>
        </div>
    </form>
</div>
@endsection
