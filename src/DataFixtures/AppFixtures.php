<?php

namespace App\DataFixtures;

use App\Entity\AgeRange;
use App\Entity\Animator;
use App\Entity\Camp;
use App\Entity\Child;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class AppFixtures extends Fixture
{
    /**
     * @var Generator
     */
    private $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager)
    {

        // Création des tranches d'age

        $ageRange1 = new AgeRange();
        $ageRange1->setSingularName('Farfadet')
            ->setPluralName('Farfadets')
            ->setMinAge(6)
            ->setMaxAge(8)
            ->setNbChildrenByAnimator(4);
        $manager->persist($ageRange1);

        $ageRange2 = new AgeRange();
        $ageRange2->setSingularName('Louveteau')
            ->setPluralName('Louveteaux')
            ->setMinAge(9)
            ->setMaxAge(11)
            ->setNbChildrenByAnimator(6);
        $manager->persist($ageRange2);

        $ageRange3 = new AgeRange();
        $ageRange3->setSingularName('Scout')
            ->setPluralName('Scouts')
            ->setMinAge(12)
            ->setMaxAge(14)
            ->setNbChildrenByAnimator(8);
        $manager->persist($ageRange3);

        $ageRange4 = new AgeRange();
        $ageRange4->setSingularName('Pionnier')
            ->setPluralName('Pionniers')
            ->setMinAge(15)
            ->setMaxAge(17)
            ->setNbChildrenByAnimator(12);
        $manager->persist($ageRange4);

        $manager->flush();

        // Création des enfants

        $numberOfChildren = 50;
        for ($i = 0; $i <= $numberOfChildren; $i++) {
            $child = new Child();
            $child->setFirstName($this->faker->firstName)
                ->setLastName($this->faker->lastName)
                ->setBirthDate($this->faker->dateTimeBetween('-17 years', '-6 years'));
            $manager->persist($child);
        }
        $child = new Child();
        $child->setFirstName($this->faker->firstName)
            ->setLastName($this->faker->lastName)
            ->setBirthDate(new \DateTime('2010-05-10'));
        $manager->persist($child);


        // Création des animateurs

        $numberOfAnimators = 15;
        $animators = [];
        for ($i = 0; $i <= $numberOfAnimators; $i++) {
            $animator = new Animator();
            $animator->setFirstName($this->faker->firstName)
                ->setLastName($this->faker->lastName);
            $animators[] = $animator;
            $manager->persist($animator);
        }

        //Création des camps

        $camp = new Camp();
        $camp->setName('Camps des Farfadets')
            ->setCapacity('30')
            ->setAgeRange($ageRange1)
            ->setStartDate(new \DateTime('2021-02-01'))
            ->setEndDate(new \DateTime('2021-02-16'))
            ->addAnimator($animators[1]);
        $manager->persist($camp);

        $camp = new Camp();
        $camp->setName('Camps des Louveteaux')
            ->setCapacity('30')
            ->setAgeRange($ageRange1)
            ->setStartDate(new \DateTime('2021-02-01'))
            ->setEndDate(new \DateTime('2021-02-16'))
            ->addAnimator($animators[2]);
        $manager->persist($camp);

        $camp = new Camp();
        $camp->setName('Camps des Scouts')
            ->setCapacity('30')
            ->setAgeRange($ageRange1)
            ->setStartDate(new \DateTime('2021-02-01'))
            ->setEndDate(new \DateTime('2021-02-16'))
            ->addAnimator($animators[3]);
        $manager->persist($camp);

        $camp = new Camp();
        $camp->setName('Camps des Pionniers')
            ->setCapacity('30')
            ->setAgeRange($ageRange1)
            ->setStartDate(new \DateTime('2021-02-01'))
            ->setEndDate(new \DateTime('2021-02-16'))
            ->addAnimator($animators[4]);
        $manager->persist($camp);


        $manager->flush();

    }

}
