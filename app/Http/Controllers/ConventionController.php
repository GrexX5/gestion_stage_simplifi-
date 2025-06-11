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

    // Valider une convention
    public function validate($id)
    {
        $convention = \App\Models\Convention::findOrFail($id);
        $convention->status = 'validated';
        $convention->save();
        return back()->with('success', 'Convention validée.');
    }

    // Rejeter une convention
    public function reject($id)
    {
        $convention = \App\Models\Convention::findOrFail($id);
        $convention->status = 'rejected';
        $convention->save();
        return back()->with('success', 'Convention rejetée.');
    }

    //
}
