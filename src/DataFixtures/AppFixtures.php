<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Group;
use App\Entity\Trick;
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
                 ->setCreatedAt(new \DateTimeImmutable())
                 ->setAvatar('1.jpg');

        $manager->persist($demoUser);

        $users = [];
        for ($i = 0; $i < 6; ++$i) {
            $user = new User();
            $user->setEmail($faker->email())
                 ->setPassword($this->hasher->hashPassword($user, 'demo'))
                 ->setUsername($faker->userName())
                 ->setCreatedAt((new \DateTimeImmutable())->modify(rand(-1, -1000) . ' days'))
                 ->setAvatar($i + 1 . '.jpg');

            if (rand(0, 1) === 1) {
                $user->setRegistrationToken($this->uuidFactory->create());
            }

            $users[] = $user;
            $manager->persist($user);
        }

        $groupLabels = ['Grab', 'Rotation', 'Flip', 'Slide', 'Old school', 'One foot', 'Jump'];

        /** @var array<string, Group> $groups */
        $groups = [];
        foreach ($groupLabels as $label) {
            $newGroup = new Group();
            $newGroup->setLabel($label);
            $groups[$label] = $newGroup;

            $manager->persist($newGroup);
        }

        $tricks   = [];
        $backflip = (new Trick())
            ->setCategory($groups['Flip'])
            ->setCoverWebPath('1_backflip.jpeg')
            ->setName('Backflip')->setSlug('backflip')
            ->setDescription($faker->text(rand(300, 3000)))
            ->setCreatedAt((new \DateTimeImmutable())->modify(rand(-1, -1000) . ' days'));
        $tricks[] = $backflip;

        $indygrab = (new Trick())
            ->setCategory($groups['Grab'])
            ->setCoverWebPath('2_indy_grab.jpg')
            ->setName('Indy Grab')->setSlug('indy-grab')
            ->setDescription($faker->text(rand(300, 3000)))
            ->setCreatedAt((new \DateTimeImmutable())->modify(rand(-1, -1000) . ' days'));
        $tricks[] = $indygrab;

        $mutegrab = (new Trick())
            ->setCategory($groups['Grab'])
            ->setCoverWebPath('3_mute_grab.jpg')
            ->setName('Mute Grab')->setSlug('mute-grab')
            ->setDescription($faker->text(rand(300, 3000)))
            ->setCreatedAt((new \DateTimeImmutable())->modify(rand(-1, -1000) . ' days'));
        $tricks[] = $mutegrab;

        $rotating = (new Trick())
            ->setCategory($groups['Rotation'])
            ->setCoverWebPath('4_rotating.jpeg')
            ->setName('360')->setSlug('rotation-360')
            ->setDescription($faker->text(rand(300, 3000)))
            ->setCreatedAt((new \DateTimeImmutable())->modify(rand(-1, -1000) . ' days'));
        $tricks[] = $rotating;

        $sadgrab  = (new Trick())
            ->setCategory($groups['Grab'])
            ->setCoverWebPath('5_sad_grab.jpg')
            ->setName('Sad Grab')->setSlug('sad-grab')
            ->setDescription($faker->text(rand(300, 3000)))
            ->setCreatedAt((new \DateTimeImmutable())->modify(rand(-1, -1000) . ' days'));
        $tricks[] = $sadgrab;

        $mctwist  = (new Trick())
            ->setCategory($groups['Grab'])
            ->setCoverWebPath('6_mctwist.jpeg')
            ->setName('MCTwist')->setSlug('mctwist')
            ->setDescription($faker->text(rand(300, 3000)))
            ->setCreatedAt((new \DateTimeImmutable())->modify(rand(-1, -1000) . ' days'));
        $tricks[] = $mctwist;

        $ollie    = (new Trick())
            ->setCategory($groups['Jump'])
            ->setCoverWebPath('7_ollie.webp')
            ->setName('Ollie')->setSlug('ollie')
            ->setDescription($faker->text(rand(300, 3000)))
            ->setCreatedAt((new \DateTimeImmutable())->modify(rand(-1, -1000) . ' days'));
        $tricks[] = $ollie;

        $press    = (new Trick())
            ->setCategory($groups['Rotation'])
            ->setCoverWebPath('8_press.webp')
            ->setName('Press')->setSlug('press')
            ->setDescription($faker->text(rand(300, 3000)))
            ->setCreatedAt((new \DateTimeImmutable())->modify(rand(-1, -1000) . ' days'));
        $tricks[] = $press;

        $fiftyfifty = (new Trick())
            ->setCategory($groups['Slide'])
            ->setCoverWebPath('9_5050.webp')
            ->setName('50/50')->setSlug('fifty-fifty')
            ->setDescription($faker->text(rand(300, 3000)))
            ->setCreatedAt((new \DateTimeImmutable())->modify(rand(-1, -1000) . ' days'));
        $tricks[]   = $fiftyfifty;

        $tripod   = (new Trick())
            ->setCategory($groups['Slide'])
            ->setCoverWebPath('10_tripod.webp')
            ->setName('Tripod')->setSlug('tripod')
            ->setDescription($faker->text(rand(300, 3000)))
            ->setCreatedAt((new \DateTimeImmutable())->modify(rand(-1, -1000) . ' days'));
        $tricks[] = $tripod;

        $manager->persist($backflip);
        $manager->persist($indygrab);
        $manager->persist($mutegrab);
        $manager->persist($rotating);
        $manager->persist($sadgrab);
        $manager->persist($mctwist);
        $manager->persist($ollie);
        $manager->persist($press);
        $manager->persist($fiftyfifty);
        $manager->persist($tripod);

        /** @var Trick $trick */
        foreach ($tricks as $trick) {
            for ($i = 0; $i < 10; $i++) {
                $comment = new Comment();
                $comment
                    ->setCreatedAt($trick->getCreatedAt()->modify('+' . rand(1, 3600) . ' seconds'))
                    ->setContent($faker->text)
                    ->setUser($users[rand(0, 5)]);

                $comment->setTrick($trick);
                $manager->persist($comment);
            }
        }

        $manager->flush();
    }
}
