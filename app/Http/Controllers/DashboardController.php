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
        $company = Auth::user()->company;
        $internshipsCount = $company ? $company->internships()->count() : 0;
        $applicationsCount = $company ? \App\Models\Application::whereHas('internship', function($q) use ($company) {
            $q->where('company_id', $company->id);
        })->count() : 0;
        return view('dashboard_company', [
            'internshipsCount' => $internshipsCount,
            'applicationsCount' => $applicationsCount,
        ]);
    }

    //
}
