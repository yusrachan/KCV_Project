<?php

namespace App\DataFixtures;

use App\Entity\TrancheHoraire;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class TrancheHoraireFixtures extends Fixture
{
    public function load(ObjectManager $manager){
        for ($heure = 9; $heure <= 15; $heure++) {
            $heureDebut = new \DateTime("$heure:00:00");
            $trancheHoraire = new TrancheHoraire();
            $trancheHoraire->setHeureDebut($heureDebut);
            $manager->persist($trancheHoraire);
        }

        $manager->flush();
    }
}