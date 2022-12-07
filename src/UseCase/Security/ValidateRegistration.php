<?php

namespace App\UseCase\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class ValidateRegistration implements ValidateRegistrationInterface
{
    public function __construct(
        private readonly EntityManagerInterface $manager
    ) {
    }

    public function __invoke(User $user): void
    {
        if ($user->hasRegistrationToken()) {
            $user->setRegistrationToken(null);
            $this->manager->persist($user);
            $this->manager->flush();
        }
    }
}
