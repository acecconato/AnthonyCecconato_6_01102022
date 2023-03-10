<?php

namespace App\DataFixtures;

use App\Entity\Group;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private readonly UserPasswordHasherInterface $hasher
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $demoUser = new User();
        $demoUser->setEmail('demo@demo.fr')
                 ->setPassword($this->hasher->hashPassword($demoUser, 'demo'))
                 ->setUsername('demo')
                 ->setCreatedAt(new \DateTimeImmutable());

        $manager->persist($demoUser);

        $groupLabels = ['Sans les mains', 'Sans les pieds', 'Sans Snowboard', 'Sans neige'];

        foreach ($groupLabels as $label) {
            $manager->persist(
                (new Group())->setLabel($label)
            );
        }

        $manager->flush();
    }
}
