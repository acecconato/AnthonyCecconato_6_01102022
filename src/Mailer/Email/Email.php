<?php

declare(strict_types=1);

namespace App\Mailer\Email;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;

abstract class Email extends TemplatedEmail implements EmailInterface
{
    protected string $code = '';

    public function getCode(): ?string
    {
        return $this->code;
    }
}
