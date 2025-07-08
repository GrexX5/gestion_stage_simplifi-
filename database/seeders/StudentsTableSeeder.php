<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StudentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = [
            [
                'name' => 'Jean Dupont',
                'email' => 'jean.dupont@etudiant.com',
                'major' => 'Informatique',
                'year' => '2024',
                'skills' => 'PHP, JavaScript, HTML/CSS, MySQL',
                'interests' => 'Développement web, IA, Cybersécurité',
            ],
            [
                'name' => 'Marie Martin',
                'email' => 'marie.martin@etudiant.com',
                'major' => 'Génie Logiciel',
                'year' => '2025',
                'skills' => 'Python, Java, C++, Algorithmes',
                'interests' => 'Développement mobile, Cloud Computing',
            ],
            [
                'name' => 'Thomas Leroy',
                'email' => 'thomas.leroy@etudiant.com',
                'major' => 'Réseaux et Télécoms',
                'year' => '2023',
                'skills' => 'Réseaux, Sécurité, Linux, Python',
                'interests' => 'Cybersécurité, Administration système',
            ],
            [
                'name' => 'Sophie Bernard',
                'email' => 'sophie.bernard@etudiant.com',
                'major' => 'Data Science',
                'year' => '2024',
                'skills' => 'Python, R, Machine Learning, SQL',
                'interests' => 'IA, Big Data, Analyse de données',
            ],
            [
                'name' => 'Lucas Petit',
                'email' => 'lucas.petit@etudiant.com',
                'major' => 'Informatique',
                'year' => '2025',
                'skills' => 'JavaScript, React, Node.js, MongoDB',
                'interests' => 'Développement Full Stack, UX/UI',
            ],
        ];

        foreach ($students as $studentData) {
            // Créer l'utilisateur
            $user = User::create([
                'name' => $studentData['name'],
                'email' => $studentData['email'],
                'password' => Hash::make('password'),
                'role' => 'student',
                'email_verified_at' => now(),
            ]);

            // Créer le profil étudiant
            Student::create([
                'user_id' => $user->id,
                'major' => $studentData['major'],
                'year' => $studentData['year'],
                'skills' => $studentData['skills'],
                'interests' => $studentData['interests'],
            ]);
        }
    }
}
