<?php

declare(strict_types=1);

namespace App\UseCase\Security;

use App\Entity\User;

interface ValidateRegistrationInterface
{
    public function __invoke(User $user): void;
}
