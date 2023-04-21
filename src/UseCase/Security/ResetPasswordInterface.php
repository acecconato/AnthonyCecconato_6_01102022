<?php

declare(strict_types=1);

namespace App\UseCase\Security;

use App\Entity\ResetPasswordRequest as ResetPasswordRequestEntity;

interface ResetPasswordInterface
{
    public function __invoke(ResetPasswordRequestEntity $resetPasswordRequest): void;
}
