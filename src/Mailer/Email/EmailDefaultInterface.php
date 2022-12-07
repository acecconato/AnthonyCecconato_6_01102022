<?php

namespace App\Mailer\Email;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\OptionsResolver\OptionsResolver;

interface EmailDefaultInterface
{
    /**
     * @param array<string, mixed> $options
     */
    public function build(TemplatedEmail $email, array $options = []): void;

    public function configureOptions(OptionsResolver $resolver): void;
}
