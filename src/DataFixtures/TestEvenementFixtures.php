<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\TestEvenement;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TestEvenementFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $evenement1 = new TestEvenement();
        $evenement1->setTitre('TestTitreEvent1');
        $evenement1->setDateDebut(new DateTime('2023-11-20 10:00:00'));
        $evenement1->setDateFin(new DateTime('2023-11-20 11:00:00'));
        $manager->persist($evenement1);
        $manager->flush();
    }
}
