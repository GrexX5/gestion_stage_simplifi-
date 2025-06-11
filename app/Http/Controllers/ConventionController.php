<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConventionController extends Controller
{
    // Liste des conventions
    public function index()
    {
        $user = Auth::user();
        if ($user->role === 'student') {
            $conventions = $user->student ? \App\Models\Convention::whereHas('application', function($q) use ($user) {
                $q->where('student_id', $user->student->id);
            })->with('application.internship.company')->get() : collect();
        } elseif ($user->role === 'company') {
            $company = $user->company;
            $conventions = $company ? \App\Models\Convention::whereHas('application.internship', function($q) use ($company) {
                $q->where('company_id', $company->id);
            })->with('application.student.user')->get() : collect();
        } else {
            // Enseignant ou admin : toutes les conventions
            $conventions = \App\Models\Convention::with('application.student.user', 'application.internship.company')->get();
        }
        return view('conventions.index', compact('conventions'));
    }
    // Afficher les détails d'une convention
    public function show($id)
    {
        $convention = \App\Models\Convention::with([
            'application.student.user',
            'application.internship.company'
        ])->findOrFail($id);

        return view('conventions.show', compact('convention'));
    }

    // Générer une convention pour une application acceptée
    public function generate($applicationId)
    {
        $application = \App\Models\Application::findOrFail($applicationId);
        if ($application->status !== 'accepted') {
            return back()->with('error', 'Seules les candidatures acceptées peuvent générer une convention.');
        }
        $convention = \App\Models\Convention::firstOrCreate([
            'application_id' => $application->id
        ], [
            'status' => 'pending',
            'document' => '',
        ]);
        return back()->with('success', 'Convention générée.');
    }

    // Valider une convention (par enseignant ou entreprise)
    public function validate($id)
    {
        $user = Auth::user();
        $convention = \App\Models\Convention::findOrFail($id);
        
        if ($user->role === 'teacher') {
            $convention->teacher_validated = true;
            $message = 'Validation enseignant enregistrée.';
        } elseif ($user->role === 'company') {
            $convention->company_validated = true;
            $message = 'Validation entreprise enregistrée.';
        } else {
            return back()->with('error', 'Action non autorisée.');
        }

        // Vérifier si la convention est complètement validée
        if ($convention->isFullyValidated()) {
            $convention->status = 'validated';
            $message = 'Convention validée avec succès !';
        }

        $convention->save();
        return back()->with('success', $message);
    }

    // Rejeter une convention
    public function reject($id)
    {
        $convention = \App\Models\Convention::findOrFail($id);
        $convention->status = 'rejected';
        $convention->teacher_validated = false;
        $convention->company_validated = false;
        $convention->save();
        return back()->with('success', 'Convention rejetée.');
    }

    //
}
