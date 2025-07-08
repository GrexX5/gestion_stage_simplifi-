<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\Company;
use App\Models\Teacher;
use App\Models\Internship;
use App\Models\Application;
use App\Models\Convention;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ConventionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer les données nécessaires
        $acceptedApplications = Application::where('status', 'accepted')->with(['student', 'internship'])->get();
        $teachers = Teacher::all();
        
        if ($acceptedApplications->isEmpty() || $teachers->isEmpty()) {
            $this->command->info('Aucune candidature acceptée ou enseignant trouvé. Assurez-vous d\'avoir des candidatures acceptées et des enseignants.');
            return;
        }

        $conventions = [
            [
                'start_date' => Carbon::now()->addDays(15),
                'end_date' => Carbon::now()->addMonths(6),
                'status' => 'pending',
                'signature_date' => null,
                'notes' => 'En attente de signature de l\'entreprise et de l\'étudiant.',
            ],
            [
                'start_date' => Carbon::now()->addDays(10),
                'end_date' => Carbon::now()->addMonths(5),
                'status' => 'validated',
                'signature_date' => Carbon::now()->subDays(5),
                'notes' => 'Convention signée par toutes les parties.',
            ],
            [
                'start_date' => Carbon::now()->addDays(20),
                'end_date' => Carbon::now()->addMonths(4),
                'status' => 'validated',
                'signature_date' => Carbon::now()->subDays(2),
                'notes' => 'Convention validée par l\'établissement.',
            ],
        ];

        foreach ($conventions as $index => $conventionData) {
            // S'assurer qu'il reste des candidatures acceptées
            if (!isset($acceptedApplications[$index])) {
                break;
            }
            
            $application = $acceptedApplications[$index];
            $internship = $application->internship;
            $company = $internship->company;
            $student = $application->student;
            $teacher = $teachers->random();
            
            // Vérifier si une convention existe déjà pour cette candidature
            $exists = Convention::where('application_id', $application->id)->exists();
            
            if (!$exists) {
                Convention::create([
                    'application_id' => $application->id,
                    'teacher_id' => $teacher->id,
                    'student_id' => $student->id,
                    'company_id' => $company->id,
                    'internship_id' => $internship->id,
                    'start_date' => $conventionData['start_date'],
                    'end_date' => $conventionData['end_date'],
                    'status' => $conventionData['status'],
                    'signature_date' => $conventionData['signature_date'],
                    'notes' => $conventionData['notes'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
        
        $this->command->info(min(count($conventions), $acceptedApplications->count()) . ' conventions ont été créées avec succès.');
    }
}
