<?php

namespace App\UseCase\Security;

use App\Entity\User;

interface RegisterInterface
{
    public function __invoke(User $user): void;
}
