<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\Internship;
use App\Models\Application;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ApplicationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer les étudiants et les stages
        $students = Student::all();
        $internships = Internship::all();
        
        if ($students->isEmpty() || $internships->isEmpty()) {
            $this->command->info('Des données manquantes. Assurez-vous d\'avoir des étudiants et des offres de stage.');
            return;
        }

        $applications = [
            [
                'motivation' => 'Je suis passionné par le développement web et je souhaite mettre en pratique mes compétences en entreprise. Votre offre correspond parfaitement à mon profil et à mes aspirations professionnelles.',
                'status' => 'pending',
                'application_date' => Carbon::now()->subDays(5),
            ],
            [
                'motivation' => 'Étudiant en informatique avec une forte appétence pour le développement mobile, je suis convaincu que ce stage chez vous me permettra de monter en compétences sur React Native tout en contribuant à des projets concrets.',
                'status' => 'accepted',
                'application_date' => Carbon::now()->subDays(10),
            ],
            [
                'motivation' => 'Mon parcours académique en data science et mes projets personnels m\'ont permis d\'acquérir des compétences solides en machine learning que je souhaite maintenant appliquer dans un cadre professionnel.',
                'status' => 'rejected',
                'application_date' => Carbon::now()->subDays(7),
            ],
            [
                'motivation' => 'La sécurité informatique est une passion pour moi depuis plusieurs années. J\'ai suivi des formations en ligne et participé à des CTF. Ce stage serait l\'opportunité idéale pour approfondir ces compétences.',
                'status' => 'pending',
                'application_date' => Carbon::now()->subDays(3),
            ],
            [
                'motivation' => 'Designer UX/UI en formation, je suis particulièrement attiré par votre approche centrée utilisateur. J\'aimerais apporter ma créativité et mes compétences en design à votre équipe pour ce stage.',
                'status' => 'pending',
                'application_date' => Carbon::now()->subDays(1),
            ],
        ];

        // Créer des candidatures
        foreach ($applications as $index => $applicationData) {
            // Sélectionner un étudiant et un stage (en bouclant si nécessaire)
            $student = $students[$index % $students->count()];
            $internship = $internships[$index % $internships->count()];
            
            // Vérifier si cette candidature existe déjà
            $exists = Application::where('student_id', $student->id)
                                ->where('internship_id', $internship->id)
                                ->exists();
            
            if (!$exists) {
                Application::create([
                    'student_id' => $student->id,
                    'internship_id' => $internship->id,
                    'motivation' => $applicationData['motivation'],
                    'status' => $applicationData['status'],
                    'application_date' => $applicationData['application_date'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
        
        $this->command->info(count($applications) . ' candidatures ont été créées avec succès.');
    }
}
