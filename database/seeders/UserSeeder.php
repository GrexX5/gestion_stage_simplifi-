<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Création d'un étudiant
        $student = User::create([
            'name' => 'Étudiant Test',
            'email' => 'etudiant@example.com',
            'password' => Hash::make('password'),
            'role' => 'student',
        ]);

        // Création du profil étudiant
        DB::table('students')->insert([
            'user_id' => $student->id,
            'major' => 'Informatique',
            'year' => '2025',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Création d'un enseignant
        $teacher = User::create([
            'name' => 'Enseignant Test',
            'email' => 'enseignant@example.com',
            'password' => Hash::make('password'),
            'role' => 'teacher',
        ]);

        DB::table('teachers')->insert([
            'user_id' => $teacher->id,
            'department' => 'Informatique',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Création d'une entreprise
        $company = User::create([
            'name' => 'Entreprise Test',
            'email' => 'entreprise@example.com',
            'password' => Hash::make('password'),
            'role' => 'company',
        ]);

        DB::table('companies')->insert([
            'user_id' => $company->id,
            'name' => 'Entreprise Test',
            'sector' => 'Informatique',
            'address' => '123 Rue de la Technologie, 75000 Paris',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
