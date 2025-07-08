<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Internship;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class InternshipsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer toutes les entreprises
        $companies = Company::all();
        
        if ($companies->isEmpty()) {
            $this->command->info('Aucune entreprise trouvée. Veuillez d\'abord exécuter le CompaniesTableSeeder.');
            return;
        }

        $internships = [
            [
                'title' => 'Développeur Full Stack',
                'description' => 'Nous recherchons un(e) stagiaire pour participer au développement de nos applications web. Vous travaillerez sur des projets concrets en utilisant les dernières technologies du marché.',
                'skills' => 'PHP, JavaScript, HTML/CSS, MySQL, Git',
                'start_date' => Carbon::now()->addMonth()->format('Y-m-d'),
                'duration' => 6,
                'location' => 'Paris (75)',
                'remuneration' => 700.00,
                'remote' => true,
                'is_active' => true,
            ],
            [
                'title' => 'Data Scientist',
                'description' => 'Rejoignez notre équipe data pour travailler sur des projets d\'analyse de données et de machine learning. Vous participerez à la conception et au déploiement de modèles prédictifs.',
                'skills' => 'Python, R, Machine Learning, SQL, Pandas, NumPy',
                'start_date' => Carbon::now()->addMonths(2)->format('Y-m-d'),
                'duration' => 5,
                'location' => 'Lyon (69)',
                'remuneration' => 800.00,
                'remote' => false,
                'is_active' => true,
            ],
            [
                'title' => 'Développeur Mobile',
                'description' => 'Participez au développement de nos applications mobiles iOS et Android. Vous travaillerez en étroite collaboration avec nos équipes de design et de développement backend.',
                'skills' => 'React Native, JavaScript, Redux, API REST',
                'start_date' => Carbon::now()->addWeeks(3)->format('Y-m-d'),
                'duration' => 4,
                'location' => 'Toulouse (31)',
                'remuneration' => 650.00,
                'remote' => true,
                'is_active' => true,
            ],
            [
                'title' => 'Expert Cybersécurité',
                'description' => 'Stage en cybersécurité pour participer à des missions d\'audit, de test d\'intrusion et de sécurisation des applications. Formation aux outils et méthodes de sécurité fournie.',
                'skills' => 'Sécurité informatique, Kali Linux, Pentest, Réseaux',
                'start_date' => Carbon::now()->addMonth()->format('Y-m-d'),
                'duration' => 6,
                'location' => 'Rennes (35)',
                'remuneration' => 750.00,
                'remote' => false,
                'is_active' => true,
            ],
            [
                'title' => 'UX/UI Designer',
                'description' => 'En tant que stagiaire UX/UI Designer, vous participerez à la conception d\'interfaces utilisateur innovantes et à l\'amélioration de l\'expérience utilisateur de nos produits digitaux.',
                'skills' => 'Figma, Adobe XD, Design Thinking, Prototypage',
                'start_date' => Carbon::now()->addWeeks(2)->format('Y-m-d'),
                'duration' => 3,
                'location' => 'Bordeaux (33)',
                'remuneration' => 600.00,
                'remote' => true,
                'is_active' => true,
            ],
        ];

        foreach ($internships as $internshipData) {
            // Sélectionner une entreprise aléatoire
            $company = $companies->random();
            
            // Créer l'offre de stage
            Internship::create([
                'company_id' => $company->id,
                'title' => $internshipData['title'],
                'description' => $internshipData['description'],
                'skills' => $internshipData['skills'],
                'start_date' => $internshipData['start_date'],
                'duration' => $internshipData['duration'],
                'location' => $internshipData['location'],
                'remuneration' => $internshipData['remuneration'],
                'remote' => $internshipData['remote'],
                'is_active' => $internshipData['is_active'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        $this->command->info(count($internships) . ' offres de stage ont été créées avec succès.');
    }
}
