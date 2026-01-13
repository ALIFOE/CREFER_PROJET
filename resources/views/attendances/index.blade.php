@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Gestion des Présences</h1>
        <a href="{{ route('attendances.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">+ Enregistrer une présence</a>
    </div>

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Étudiant</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Cours</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Remarques</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($attendances as $attendance)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $attendance->student->firstname }} {{ $attendance->student->lastname }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $attendance->course->course_name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $attendance->attendance_date->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 text-sm">
                        <span class="px-2 py-1 rounded-full text-xs font-medium
                            @if($attendance->status === 'present') bg-green-100 text-green-800
                            @elseif($attendance->status === 'absent') bg-red-100 text-red-800
                            @else bg-yellow-100 text-yellow-800
                            @endif">
                            {{ $attendance->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $attendance->remarks ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm font-medium">
                        <a href="{{ route('attendances.edit', $attendance->attendance_id) }}" class="text-yellow-600 hover:text-yellow-800 mr-2">Modifier</a>
                        <form method="POST" action="{{ route('attendances.destroy', $attendance->attendance_id) }}" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Êtes-vous sûr ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $attendances->links() }}
    </div>
</div>
@endsection
