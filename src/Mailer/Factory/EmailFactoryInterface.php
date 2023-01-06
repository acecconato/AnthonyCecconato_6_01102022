<?php

declare(strict_types=1);

namespace App\Mailer\Factory;

use App\Mailer\Email\Email;

interface EmailFactoryInterface
{
    public function createNew(string $code): Email;
}
