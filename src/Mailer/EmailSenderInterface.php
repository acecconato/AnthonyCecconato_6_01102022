<?php

declare(strict_types=1);

namespace App\Mailer;

use Symfony\Component\Mime\Address;

interface EmailSenderInterface
{
    /**
     * @param array<string, mixed> $options
     */
    public function send(string $code, Address $to, array $options = []): void;
}
