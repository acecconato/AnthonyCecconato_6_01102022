<?php

declare(strict_types=1);

namespace App\Mailer\Provider;

use App\Mailer\Email\Email;

interface EmailProviderInterface
{
    public function getEmail(string $code): Email;
}
