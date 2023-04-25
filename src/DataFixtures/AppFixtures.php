<?php

namespace App\DataFixtures;

use App\Entity\Group;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Uid\Factory\UuidFactory;

class AppFixtures extends Fixture
{
    public function __construct(
        private readonly UserPasswordHasherInterface $hasher,
        private readonly UuidFactory $uuidFactory
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr');

        $demoUser = new User();
        $demoUser->setEmail('demo@demo.fr')
                 ->setPassword($this->hasher->hashPassword($demoUser, 'demo'))
                 ->setUsername('demo')
                 ->setCreatedAt(new \DateTimeImmutable());

        $manager->persist($demoUser);

        for ($i = 0; $i < 6; ++$i) {
            $user = new User();
            $user->setEmail($faker->email())
                 ->setPassword($this->hasher->hashPassword($user, 'demo'))
                 ->setUsername($faker->userName())
                 ->setCreatedAt((new \DateTimeImmutable())->modify(rand(-1, -1000).' days'));

            if ((bool) rand(0, 1)) {
                $user->setRegistrationToken($this->uuidFactory->create());
            }

            $manager->persist($user);
        }

        $groupLabels = ['Grab', 'Rotation', 'Flip', 'Slide', 'Old school', 'One foot'];

        foreach ($groupLabels as $label) {
            $manager->persist(
                (new Group())->setLabel($label)
            );
        }

        $manager->flush();
    }
}
