<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Teacher;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TeachersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teachers = [
            [
                'name' => 'Prof. Robert Durand',
                'email' => 'r.durand@univ.fr',
                'department' => 'Informatique',
                'specialty' => 'Algorithmique avancée, Intelligence Artificielle',
                'office' => 'Bâtiment A, Bureau 205',
                'phone' => '0145879632',
            ],
            [
                'name' => 'Prof. Sophie Laurent',
                'email' => 's.laurent@univ.fr',
                'department' => 'Réseaux et Télécoms',
                'specialty' => 'Réseaux avancés, Cybersécurité',
                'office' => 'Bâtiment B, Bureau 112',
                'phone' => '0145879633',
            ],
            [
                'name' => 'Prof. Michel Bernard',
                'email' => 'm.bernard@univ.fr',
                'department' => 'Génie Logiciel',
                'specialty' => 'Architecture logicielle, Méthodes agiles',
                'office' => 'Bâtiment C, Bureau 308',
                'phone' => '0145879634',
            ],
            [
                'name' => 'Prof. Isabelle Martin',
                'email' => 'i.martin@univ.fr',
                'department' => 'Data Science',
                'specialty' => 'Machine Learning, Big Data',
                'office' => 'Bâtiment A, Bureau 210',
                'phone' => '0145879635',
            ],
            [
                'name' => 'Prof. Thomas Petit',
                'email' => 't.petit@univ.fr',
                'department' => 'Développement Web',
                'specialty' => 'Frameworks JavaScript, UX/UI',
                'office' => 'Bâtiment B, Bureau 215',
                'phone' => '0145879636',
            ],
        ];

        foreach ($teachers as $teacherData) {
            // Créer l'utilisateur
            $user = User::create([
                'name' => $teacherData['name'],
                'email' => $teacherData['email'],
                'password' => Hash::make('password'),
                'role' => 'teacher',
                'email_verified_at' => now(),
            ]);

            // Créer le profil enseignant
            Teacher::create([
                'user_id' => $user->id,
                'department' => $teacherData['department'],
                'specialty' => $teacherData['specialty'],
                'office' => $teacherData['office'],
                'phone' => $teacherData['phone'],
            ]);
        }
    }
}
