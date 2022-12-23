<?php

declare(strict_types=1);

namespace App\UseCase\Security;

use App\Entity\ResetPassword;
use App\Repository\ResetPasswordRepository;
use Doctrine\ORM\EntityManagerInterface;

final class ResetPasswordRequest implements ResetPasswordRequestInterface
{
    public function __construct(
        private readonly EntityManagerInterface $manager,
        private readonly ResetPasswordRepository $resetPasswordRepository
    ) {
    }

    public function __invoke(ResetPassword $resetPassword): void
    {
//        $user = $resetPassword->getUser();
//        $this->resetPasswordRepository->findOneBy(['email' => $resetPassword->getUser()])
    }
}
