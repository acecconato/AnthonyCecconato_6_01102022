<?php

namespace App\Mailer\Email;

use App\Entity\User;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationMail implements EmailDefaultInterface
{
    public function build(TemplatedEmail $email, array $options = []): void
    {
        /** @var User $user */
        $user = $options['user'];

        $email
            ->to(new Address($user->getEmail(), $user->getUsername() ?? ''))
            ->subject('Création de votre compte Snowtricks')
            ->htmlTemplate('emails/registration.email.twig')
            ->context(['user' => $user]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setRequired('user')
            ->setAllowedTypes('user', User::class);
    }
}
