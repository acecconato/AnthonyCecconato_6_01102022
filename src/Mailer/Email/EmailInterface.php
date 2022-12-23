<?php

declare(strict_types=1);

namespace App\Mailer\Email;

use Symfony\Component\OptionsResolver\OptionsResolver;

interface EmailInterface
{
    public function getCode(): ?string;

    public function build(): EmailInterface;

    public function configureOptions(OptionsResolver $resolver): void;
}
