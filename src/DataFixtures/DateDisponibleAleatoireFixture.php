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
}
