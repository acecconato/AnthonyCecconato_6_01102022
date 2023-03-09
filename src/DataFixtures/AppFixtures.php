<?php

namespace App\DataFixtures;

use App\Entity\Group;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $groupLabels = ['Sans les mains', 'Sans les pieds', 'Sans Snowboard', 'Sans neige'];

        foreach ($groupLabels as $label) {
            $manager->persist(
                (new Group())->setLabel($label)
            );
        }

        $manager->flush();
    }
}
