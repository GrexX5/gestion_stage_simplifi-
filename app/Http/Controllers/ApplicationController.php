<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    // Liste des candidatures (étudiant : ses candidatures, entreprise : pour ses stages)
    public function index()
    {
        $user = Auth::user();
        if ($user->role === 'student') {
            $applications = $user->student ? $user->student->applications()->with('internship')->get() : collect();
        } elseif ($user->role === 'company') {
            $company = $user->company;
            $applications = $company ? \App\Models\Application::whereHas('internship', function($q) use ($company) {
                $q->where('company_id', $company->id);
            })->with('student', 'internship')->get() : collect();
        } else {
            $applications = \App\Models\Application::with('student', 'internship')->get();
        }
        return view('applications.index', compact('applications'));
    }

    // Soumettre une candidature (étudiant)
    public function store(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'internship_id' => 'required|exists:internships,id',
        ]);
        
        // Vérifier que l'utilisateur a un profil étudiant
        if (!$user->student) {
            return redirect()->back()->with('error', 'Vous devez avoir un profil étudiant pour postuler à une offre.');
        }
        
        $student = $user->student;
        $internshipId = $request->internship_id;
        
        // Empêcher la double candidature
        $exists = \App\Models\Application::where('student_id', $student->id)
            ->where('internship_id', $internshipId)->exists();
            
        if ($exists) {
            return redirect()->back()->with('error', 'Vous avez déjà postulé à cette offre.');
        }
        
        $application = \App\Models\Application::create([
            'student_id' => $student->id,
            'internship_id' => $internshipId,
            'application_date' => now(),
            'status' => 'pending',
        ]);

        // Récupérer l'entreprise liée au stage
        $internship = \App\Models\Internship::findOrFail($internshipId);
        
        // Vérifier et définir les dates par défaut si nécessaire
        $startDate = $internship->start_date ?? now()->addWeek()->startOfWeek(); // Par défaut, dans une semaine
        $endDate = $internship->end_date ?? $startDate->copy()->addMonths(2); // Par défaut, 2 mois après la date de début
        
        // Créer automatiquement une convention pour cette candidature
        $convention = new \App\Models\Convention([
            'application_id' => $application->id,
            'student_id' => $student->id,
            'company_id' => $internship->company_id,
            'internship_id' => $internshipId,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'signature_date' => now(),
            'status' => 'pending',
            'teacher_validated' => false,
            'company_validated' => false,
        ]);
        $convention->save();

        return redirect()->route('applications.index')
            ->with('success', 'Candidature envoyée. Une convention a été créée et est en attente de validation.');
    }

    // Détail d'une candidature
    public function show($id)
    {
        $application = \App\Models\Application::with('student.user', 'internship.company')->findOrFail($id);
        return view('applications.show', compact('application'));
    }

    // Changer le statut (accept/reject) - entreprise ou admin
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:accepted,rejected',
        ]);
        $application = \App\Models\Application::findOrFail($id);
        $application->status = $request->status;
        $application->save();
        return redirect()->back()->with('success', 'Statut de la candidature mis à jour.');
    }

    //
}
