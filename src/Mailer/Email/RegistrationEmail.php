<?php

declare(strict_types=1);

namespace App\Mailer\Email;

use App\Entity\User;
use Symfony\Component\Mime\Address;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class RegistrationEmail extends Email
{
    protected string $code = 'registration';

    public function __construct(
        private readonly string $defaultSender
    ) {
        parent::__construct();
    }

    public function build(): EmailInterface
    {
        return $this
            ->subject('Création de votre compte')
            ->htmlTemplate('emails/registration.html.twig')
            ->sender(new Address($this->defaultSender, 'Snowtricks'));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setRequired('user');
        $resolver->setAllowedTypes('user', User::class);
    }
}
