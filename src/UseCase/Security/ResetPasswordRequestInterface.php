<?php

declare(strict_types=1);

namespace App\UseCase\Security;

interface ResetPasswordRequestInterface
{
    public function __invoke(string $email): void;
}
