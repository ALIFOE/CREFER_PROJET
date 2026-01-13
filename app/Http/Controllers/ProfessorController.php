<?php

namespace App\Http\Controllers;

use App\Models\Professor;
use Illuminate\Http\Request;

class ProfessorController extends Controller
{
    public function index()
    {
        $professors = Professor::paginate(15);
        return view('professors.index', compact('professors'));
    }

    public function create()
    {
        return view('professors.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:professors,email',
            'phone' => 'nullable|string|max:20',
            'specialization' => 'required|string|max:255',
            'hire_date' => 'required|date',
            'status' => 'required|in:active,inactive,on_leave',
        ]);

        Professor::create($validated);
        return redirect()->route('professors.index')->with('success', 'Professeur créé avec succès');
    }

    public function show(Professor $professor)
    {
        return view('professors.show', compact('professor'));
    }

    public function edit(Professor $professor)
    {
        return view('professors.edit', compact('professor'));
    }

    public function update(Request $request, Professor $professor)
    {
        $validated = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:professors,email,' . $professor->professor_id . ',professor_id',
            'phone' => 'nullable|string|max:20',
            'specialization' => 'required|string|max:255',
            'hire_date' => 'required|date',
            'status' => 'required|in:active,inactive,on_leave',
        ]);

        $professor->update($validated);
        return redirect()->route('professors.index')->with('success', 'Professeur modifié avec succès');
    }

    public function destroy(Professor $professor)
    {
        $professor->delete();
        return redirect()->route('professors.index')->with('success', 'Professeur supprimé avec succès');
    }
}
