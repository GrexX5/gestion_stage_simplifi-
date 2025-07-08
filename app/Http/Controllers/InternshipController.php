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
                $query->where(function($q) use ($search) {
                    $q->where('title', 'like', "%$search%")
                      ->orWhere('description', 'like', "%$search%")
                      ->orWhere('skills', 'like', "%$search%");
                });
            }
            if ($duration) {
                $query->where('duration', $duration);
            }
            if ($skills) {
                $query->where('skills', 'like', "%$skills%");
            }
        } elseif ($user->role === 'company') {
            $company = $user->company;
            if ($company) {
                $query = $company->internships()->with('applications.student.user');
            } else {
                $query->whereNull('id'); // Retourne une requête vide
            }
        }

        // Pagination avec 10 éléments par page
        $internships = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('internships.index', compact('internships', 'search', 'duration', 'skills'));
    }

    // Formulaire création
    public function create()
    {
        $companies = \App\Models\Company::all();
        return view('internships.create', compact('companies'));
    }

    // Enregistrer un stage
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'duration' => 'required|integer|min:1|max:12',
            'skills' => 'required|array|min:1',
            'skills.*' => 'string|max:255',
        ]);

        $company = Auth::user()->company;
        
        // Convertir le tableau des compétences en chaîne séparée par des virgules
        $skillsString = is_array($validated['skills']) 
            ? implode(', ', $validated['skills'])
            : $validated['skills'];

        \App\Models\Internship::create([
            'company_id' => $company->id,
            'title' => $validated['title'],
            'description' => $validated['description'],
            'duration' => $validated['duration'],
            'skills' => $skillsString,
        ]);

        return redirect()->route('internships.index')->with('success', 'Stage créé avec succès.');
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
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'duration' => 'required|integer|min:1|max:12',
            'skills' => 'required|array|min:1',
            'skills.*' => 'string|max:255',
        ]);

        $internship = \App\Models\Internship::findOrFail($id);
        
        // Convertir le tableau des compétences en chaîne séparée par des virgules
        $validated['skills'] = is_array($validated['skills']) 
            ? implode(', ', $validated['skills'])
            : $validated['skills'];
            
        $internship->update($validated);
        
        return redirect()->route('internships.index')->with('success', 'Stage mis à jour avec succès.');
    }

    // Suppression d'un stage
    public function destroy($id)
    {
        $internship = \App\Models\Internship::findOrFail($id);
        $internship->delete();
        return redirect()->route('internships.index')->with('success', 'Stage supprimé.');
    }


}

