<?php

namespace App\DataFixtures;

use App\Entity\Disponibilite;
use App\Entity\Kinesitherapeute;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TrancheHoraireDisponibiliteFixture extends Fixture implements DependentFixtureInterface
{
    
    /**
     * Cette fixture établit des relations many-to-many entre les entités TrancheHoraire et Disponibilite.
     * Elle ajoute de manière aléatoire une tranche horaire à chaque disponibilité.
     *
     * @param ObjectManager $manager Gestionnaire d'entités Doctrine pour la persistance des données.
     */
    public function load(ObjectManager $manager): void
    {
        $disponibilites = $manager->getRepository(Disponibilite::class)->findAll();
        $trancheHoraires = $manager->getRepository(TrancheHoraire::class)->findAll();

        foreach ($disponibilites as $disponibilite) {
            $randomIndex = mt_rand(0, count($trancheHoraires) - 1);

            $trancheHoraire = $trancheHoraires[$randomIndex];
            $disponibilite->addTrancheDispo($trancheHoraire);

            $manager->persist($disponibilite);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            DateDisponibleAleatoireFixture::class,
            TrancheHoraireFixtures::class,
        ];
    }
}
