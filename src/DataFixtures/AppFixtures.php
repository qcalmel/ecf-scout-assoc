<?php

namespace App\DataFixtures;

use App\Entity\AgeRange;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $ageRange = new AgeRange();
        $ageRange->setName('Farfade')
            ->setMinAge()
            ->setMaxAge()
            ->setNbChildrenByAnimator();
        $manager->persist($ageRange);

        $manager->flush();
    }
}
