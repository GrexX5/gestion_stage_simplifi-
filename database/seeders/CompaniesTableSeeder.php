<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companies = [
            [
                'name' => 'TechSoft Solutions',
                'email' => 'contact@techsoft-solutions.com',
                'sector' => 'Développement Logiciel',
                'address' => '45 Avenue des Champs-Élysées, 75008 Paris',
                'phone' => '0142567890',
                'website' => 'https://techsoft-solutions.com',
                'description' => 'Éditeur de logiciels innovants spécialisé dans les solutions d\'entreprise.',
            ],
            [
                'name' => 'WebCraft Studio',
                'email' => 'info@webcraft-studio.fr',
                'sector' => 'Développement Web',
                'address' => '22 Rue du Faubourg Saint-Honoré, 75001 Paris',
                'phone' => '0145987632',
                'website' => 'https://webcraft-studio.fr',
                'description' => 'Agence web créative spécialisée dans le développement sur mesure et le design UX/UI.',
            ],
            [
                'name' => 'DataForge',
                'email' => 'contact@dataforge.com',
                'sector' => 'Big Data & IA',
                'address' => '14 Rue de la Paix, 75002 Paris',
                'phone' => '0132654987',
                'website' => 'https://dataforge.com',
                'description' => 'Expert en analyse de données et solutions d\'intelligence artificielle pour les entreprises.',
            ],
            [
                'name' => 'CloudNova',
                'email' => 'hello@cloudnova.io',
                'sector' => 'Cloud Computing',
                'address' => '8 Boulevard Haussmann, 75009 Paris',
                'phone' => '0187965432',
                'website' => 'https://cloudnova.io',
                'description' => 'Solutions de cloud computing et d\'infrastructure pour les entreprises modernes.',
            ],
            [
                'name' => 'CyberShield',
                'email' => 'security@cybershield.fr',
                'sector' => 'Cybersécurité',
                'address' => '30 Avenue de l\'Opéra, 75001 Paris',
                'phone' => '0178456321',
                'website' => 'https://cybershield.fr',
                'description' => 'Expert en sécurité informatique et protection des données sensibles.',
            ],
        ];

        foreach ($companies as $companyData) {
            // Créer l'utilisateur
            $user = User::create([
                'name' => $companyData['name'],
                'email' => $companyData['email'],
                'password' => Hash::make('password'),
                'role' => 'company',
                'email_verified_at' => now(),
            ]);

            // Créer l'entreprise associée
            Company::create([
                'user_id' => $user->id,
                'name' => $companyData['name'],
                'sector' => $companyData['sector'],
                'address' => $companyData['address'],
                'phone' => $companyData['phone'],
                'website' => $companyData['website'],
                'description' => $companyData['description'],
            ]);
        }
    }
}
