<?php

/**
 * Classe pour remplir la bd avec des dispo pour chaque kiné
 */

namespace App\DataFixtures;

use DateTime;
use Faker\Factory;
use App\Entity\Disponibilite;
use App\Entity\Kinesitherapeute;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\DataFixtures\KinesitherapeuteFixtures;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class DateDisponibleAleatoireFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create();

        $rep = $manager->getRepository(Kinesitherapeute::class);
        $kines = $rep->findAll();

        foreach ($kines as $kine) {
            for ($i = 0; $i < 10; $i++) {
                $disponibilite = new Disponibilite();

                $disponibilite->setDateDisponible(new DateTime("2023-11-" . (($i + rand(1, 5)) % 28)));

                $disponibilite->setTextColor('#FF0000');
                $disponibilite->setBackgroundColor('#FFFFFF');
                $disponibilite->setBorderColor('#FFFFFF');

                $disponibilite->setKineDispo($kine);

                $manager->persist($disponibilite);
            }

            $manager->flush();
        }
    }

    public function getDependencies()
    {
        return [KinesitherapeuteFixtures::class];
    }

    public function genererDisponibilitesAleatoires(EntityManagerInterface $entityManager)
    {
        $kines = $entityManager->getRepository(Kinesitherapeute::class)->findAll();

        foreach ($kines as $kine) {
            // Obtenez les disponibilités existantes pour ce kiné dans une journée spécifique (par exemple, aujourd'hui)
            $disponibilitesExistantes = $entityManager->getRepository(Disponibilite::class)->findBy([
                'kineDispo' => $kine,
                'dateDisponible' => new \DateTime('today'),
            ]);

            // Obtenez les heures disponibles pour ce kiné
            $heuresDisponibles = $this->getHeuresDisponibles($entityManager, $kine);

            // Générez une heure aléatoire qui n'est pas déjà utilisée
            $heureAleatoire = $this->getHeureAleatoireNonUtilisee($disponibilitesExistantes, $heuresDisponibles);

            // Créez une nouvelle disponibilité avec l'heure aléatoire
            $nouvelleDisponibilite = new Disponibilite();
            $nouvelleDisponibilite->setKineDispo($kine);
            $nouvelleDisponibilite->setDateDisponible(new \DateTime('today ' . $heureAleatoire));
            // ... d'autres paramètres de disponibilité ...

            // Persistez et flush
            $entityManager->persist($nouvelleDisponibilite);
            $entityManager->flush();
        }
    }

    private function getHeureAleatoireNonUtilisee(array $disponibilitesExistantes, array $heuresDisponibles)
    {
        // Obtenez toutes les heures déjà utilisées dans les disponibilités existantes
        $heuresUtilisees = array_map(function ($disponibilite) {
            return $disponibilite->getDateDisponible()->format('H:i:s');
        }, $disponibilitesExistantes);

        // Filtrez les heures disponibles pour ne conserver que celles qui ne sont pas déjà utilisées
        $heuresNonUtilisees = array_diff($heuresDisponibles, $heuresUtilisees);

        // Choisissez une heure aléatoire parmi les heures disponibles non utilisées
        $heureAleatoire = $heuresNonUtilisees[array_rand($heuresNonUtilisees)];

        return $heureAleatoire;
    }

    private function getHeuresDisponibles(EntityManagerInterface $entityManager, Kinesitherapeute $kine)
    {
        // Obtenez les heures disponibles pour ce kiné (peut provenir de la table TrancheHoraire)
        $trancheHoraires = $entityManager->getRepository(TrancheHoraire::class)->findBy([
            'kine' => $kine,
        ]);

        // Extrait les heures au format H:i:s
        $heuresDisponibles = array_map(function ($trancheHoraire) {
            return $trancheHoraire->getHeure()->format('H:i:s');
        }, $trancheHoraires);

        return $heuresDisponibles;
    }
}
