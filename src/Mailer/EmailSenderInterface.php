<?php

namespace App\Mailer;

interface EmailSenderInterface
{
    /**
     * @param array<string, mixed> $options
     *
     * @return \App\Mailer\EmailSenderInterface
     */
    public function with(array $options): EmailSenderInterface;

    public function send(string $className): void;
}
