<?php

namespace App\DataFixtures;

use App\Entity\Kinesitherapeute;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class KinesitherapeuteFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Créez un ou plusieurs objets Kinesitherapeute et ajoutez-les à la base de données
        $kine1 = new Kinesitherapeute();
        $kine1->setNom('Arigui');
        $kine1->setPrenom('Yassine');
        $kine1->setEmail('yassine@gmail.com');
        $manager->persist($kine1);

        $kine2 = new Kinesitherapeute();
        $kine2->setNom('Truc');
        $kine2->setPrenom('Julie');
        $kine2->setEmail('julie@gmail.com');
        $manager->persist($kine2);

        $kine3 = new Kinesitherapeute();
        $kine3->setNom('El Machin');
        $kine3->setPrenom('Ayyoub');
        $kine3->setEmail('ayyoub@gmail.com');
        $manager->persist($kine3);

        $manager->flush();
    }
}
