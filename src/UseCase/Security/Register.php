<?php

declare(strict_types=1);

namespace App\UseCase\Security;

use App\Entity\User;
use App\Mailer\EmailSenderInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Uid\Uuid;

final class Register extends AbstractController implements RegisterInterface
{
    public function __construct(
        private readonly EntityManagerInterface $manager,
        private readonly UserPasswordHasherInterface $hasher,
        private readonly EmailSenderInterface $sender
    ) {
    }

    /**
     * @throws \Throwable
     */
    public function __invoke(User $user): void
    {
        $user
            ->setPassword($this->hasher->hashPassword($user, (string)$user->getPlainPassword()))
            ->setCreatedAt(new \DateTimeImmutable())
            ->setRegistrationToken(Uuid::v6());

        $this->manager->persist($user);

        $this->sender->send(
            'registration',
            new Address($user->getEmail(), $user->getUsername()),
            ['user' => $user]
        );

        $this->manager->flush();
    }
}
