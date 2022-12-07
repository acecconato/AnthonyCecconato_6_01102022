<?php

namespace App\UseCase\Security;

use App\Entity\User;

interface ValidateRegistrationInterface
{
    public function __invoke(User $user): void;
}
