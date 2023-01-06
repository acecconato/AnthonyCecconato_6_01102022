<?php

declare(strict_types=1);

namespace App\UseCase\Security;

use App\Entity\ResetPasswordRequest as ResetPasswordRequestEntity;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ResetPassword implements ResetPasswordInterface
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly UserPasswordHasherInterface $hasher,
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    public function __invoke(ResetPasswordRequestEntity $resetPasswordRequest): void
    {
        $user = $resetPasswordRequest->getUser();

        $newPasswordHashed = $this->hasher->hashPassword($user, $user->getPlainPassword());
        $this->userRepository->upgradePassword($user, $newPasswordHashed);
        $user->eraseCredentials();

        $this->entityManager->remove($resetPasswordRequest);
        $this->entityManager->flush();
    }
}
