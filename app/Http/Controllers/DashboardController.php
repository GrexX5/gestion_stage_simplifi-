<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function studentDashboard()
    {
        $student = Auth::user()->student;
        $applicationsCount = $student ? $student->applications()->count() : 0;
        $conventionsCount = $student ? \App\Models\Convention::whereHas('application', function($q) use ($student) {
            $q->where('student_id', $student->id);
        })->count() : 0;
        return view('dashboard_student', [
            'applicationsCount' => $applicationsCount,
            'conventionsCount' => $conventionsCount,
        ]);
    }
    public function teacherDashboard()
    {
        $teacher = Auth::user()->teacher;
        // Exemples de stats pour un enseignant (à adapter selon besoins)
        $studentsCount = \App\Models\Student::count();
        $internshipsCount = \App\Models\Internship::count();
        return view('dashboard_teacher', [
            'studentsCount' => $studentsCount,
            'internshipsCount' => $internshipsCount,
        ]);
    }
    public function companyDashboard()
    {
        $user = Auth::user();
        $company = $user->company;
        
        if (!$company) {
            return redirect()->route('company.profile.create')
                ->with('warning', 'Veuillez compléter votre profil entreprise avant d\'accéder au tableau de bord.');
        }
        
        // Get recent activities (last 10 activities)
        $recentActivities = collect();
        
        // Get recent internships
        $recentInternships = $company->internships()
            ->latest()
            ->take(5)
            ->get()
            ->map(function($internship) {
                return (object)[
                    'type' => 'internship_created',
                    'created_at' => $internship->created_at,
                    'title' => 'Nouveau stage publié: ' . $internship->title,
                    'internship' => $internship
                ];
            });
            
        // Get recent applications
        $recentApplications = $company->internships()
            ->with(['applications' => function($query) {
                $query->with('student')
                      ->latest()
                      ->take(5);
            }])
            ->get()
            ->pluck('applications')
            ->flatten()
            ->map(function($application) {
                return (object)[
                    'type' => 'application_received',
                    'created_at' => $application->created_at,
                    'title' => 'Nouvelle candidature reçue de ' . ($application->student->user->name ?? 'un étudiant'),
                    'application' => $application
                ];
            });
            
        // Combine and sort all activities
        $recentActivities = $recentInternships->merge($recentApplications)
            ->sortByDesc('created_at')
            ->take(10);

        return view('dashboard_company', [
            'company' => $company,
            'internships' => $company->internships()->withCount('applications')->latest()->take(5)->get(),
            'recentApplications' => $company->internships()
                ->with(['applications' => function($query) {
                    $query->with('student')->latest()->take(5);
                }])
                ->get()
                ->pluck('applications')
                ->flatten(),
            'recentActivities' => $recentActivities,
        ]);
    }

    //
}
