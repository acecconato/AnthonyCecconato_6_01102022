<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use App\Validator\SlugValidator;
use Symfony\Component\Validator\Constraint;

#[\Attribute]
final class Slug extends Constraint
{
    public string $message = 'Le slug est invalide';

    public function validatedBy(): string
    {
        return SlugValidator::class;
    }
}
