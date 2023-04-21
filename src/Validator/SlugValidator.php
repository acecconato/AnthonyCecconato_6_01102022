<?php

declare(strict_types=1);

namespace App\Validator;

use App\Validator\Constraints\Slug;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

final class SlugValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof Slug) {
            throw new UnexpectedTypeException($constraint, Slug::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!is_string($value)) {
            throw new UnexpectedValueException($value, 'string');
        }

        if (!(bool)preg_match('/^[a-z\d]+(?:-[a-z\d]+)*$/', $value)) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}
