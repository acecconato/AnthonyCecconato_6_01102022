<?php

declare(strict_types=1);

namespace App\Mailer\Provider;

use App\Mailer\Email\Email;
use App\Mailer\Factory\EmailFactoryInterface;

class EmailProvider implements EmailProviderInterface
{
    public function __construct(
        private readonly EmailFactoryInterface $emailFactory
    ) {
    }

    public function getEmail(string $code): Email
    {
        $email = $this->emailFactory->createNew($code);
        $email->build();

        return $email;
    }
}
