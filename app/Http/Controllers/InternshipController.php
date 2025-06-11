<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InternshipController extends Controller
{
    // Liste des stages
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = \App\Models\Internship::with('company');
        $search = $request->input('search');
        $duration = $request->input('duration');
        $skills = $request->input('skills');

        // Filtres étudiants
        if ($user->role === 'student') {
            if ($search) {
                $query->where('title', 'like', "%$search%")
                      ->orWhere('description', 'like', "%$search%")
                      ->orWhere('skills', 'like', "%$search%") ;
            }
            if ($duration) {
                $query->where('duration', $duration);
            }
            if ($skills) {
                $query->where('skills', 'like', "%$skills%") ;
            }
            $internships = $query->get();
        } elseif ($user->role === 'company') {
            $company = $user->company;
            $internships = $company ? $company->internships()->with('applications.student.user')->get() : collect();
        } else {
            $internships = $query->get();
        }
        return view('internships.index', compact('internships', 'search', 'duration', 'skills'));
    }

    // Formulaire création
    public function create()
    {
        return view('internships.create');
    }

    // Enregistrer un stage
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'duration' => 'required',
            'skills' => 'required',
        ]);
        $company = Auth::user()->company;
        \App\Models\Internship::create([
            'company_id' => $company->id,
            'title' => $request->title,
            'description' => $request->description,
            'duration' => $request->duration,
            'skills' => $request->skills,
        ]);
        return redirect()->route('internships.index')->with('success', 'Stage créé.');
    }

    // Afficher un stage
    public function show($id)
    {
        $internship = \App\Models\Internship::with('company', 'applications.student.user')->findOrFail($id);
        $user = Auth::user();
        $alreadyApplied = false;
        if ($user->role === 'student' && $user->student) {
            $alreadyApplied = \App\Models\Application::where('student_id', $user->student->id)
                ->where('internship_id', $internship->id)->exists();
        }
        return view('internships.show', compact('internship', 'alreadyApplied'));
    }

    // Formulaire édition
    public function edit($id)
    {
        $internship = \App\Models\Internship::findOrFail($id);
        return view('internships.edit', compact('internship'));
    }

    // Mise à jour d'un stage
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'duration' => 'required',
            'skills' => 'required',
        ]);
        $internship = \App\Models\Internship::findOrFail($id);
        $internship->update($request->only(['title', 'description', 'duration', 'skills']));
        return redirect()->route('internships.index')->with('success', 'Stage mis à jour.');
    }

    // Suppression d'un stage
    public function destroy($id)
    {
        $internship = \App\Models\Internship::findOrFail($id);
        $internship->delete();
        return redirect()->route('internships.index')->with('success', 'Stage supprimé.');
    }


}

