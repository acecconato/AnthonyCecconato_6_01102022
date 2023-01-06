<?php

declare(strict_types=1);

namespace App\Mailer;

use App\Mailer\Provider\EmailProviderInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmailSender implements EmailSenderInterface
{
    public function __construct(
        private readonly MailerInterface $mailer,
        private readonly EmailProviderInterface $provider
    ) {
    }

    /**
     * @param array<string, mixed> $options
     *
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function send(string $code, Address $to, array $options = []): void
    {
        $email = $this->provider->getEmail($code);
        $email->to($to);

        $optionResolver = new OptionsResolver();
        $email->configureOptions($optionResolver);
        $optionResolver->resolve($options);

        $email->context($options);

        $this->mailer->send($email);
    }
}
