<?php

namespace App\DataFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Factory\CongeFactory;
use App\Factory\UserFactory;


class AppFixtures extends Fixture
{
    /**
     * Cette méthode charge des données fictives pour la gestion des congés.
     */
    public function load(ObjectManager $manager): void
    {
        // Crée des utilisateurs fictifs
        $users = UserFactory::new()->createMany(10, function () {
            return [
                'nom' => 'Nom' . rand(1, 100),
                'prenom' => 'Prénom' . rand(1, 100),
                'email' => 'user' . rand(1, 100) . '@example.com',
                'password' => password_hash('password', PASSWORD_BCRYPT),
            ];
        });

        // Crée des types de congés
        $typesDeConges = [
            'Congé annuel',
            'Congé maladie',
            'Congé sans solde',
            'Congé maternité/paternité',
            'RTT',
            'Congé sabbatique'
        ];

        // Associe chaque utilisateur à des congés fictifs
        foreach ($users as $user) {
            foreach ($typesDeConges as $typeDeConge) {
                CongeFactory::new()->create([
                    'type' => $typeDeConge,
                    'dateDebut' => new \DateTime(sprintf('-%d days', rand(1, 30))),
                    'dateFin' => new \DateTime(sprintf('-%d days', rand(1, 10))),
                    'status' => rand(0, 1) ? 'approuvé' : 'en attente',
                    'user' => $user
                ]);
            }
        }
    }
}
