<?php

declare(strict_types=1);

namespace App\UseCase\Security;

use App\Entity\ResetPassword;

interface ResetPasswordRequestInterface
{
    public function __invoke(ResetPassword $resetPassword): void;
}
