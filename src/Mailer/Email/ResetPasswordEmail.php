<?php

declare(strict_types=1);

namespace App\Mailer\Email;

use Symfony\Component\Mime\Address;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class ResetPasswordEmail extends Email
{
    protected string $code = 'reset_password';

    public function __construct(
        private readonly string $defaultSender
    ) {
        parent::__construct();
    }

    public function build(): EmailInterface
    {
        return $this
            ->subject('Réinitialisation de votre mot de passe')
            ->htmlTemplate('emails/reset_password.email.twig')
            ->sender(new Address($this->defaultSender, 'Snowtricks'));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setRequired('resetPasswordRequest');
    }
}
