<?php

declare(strict_types=1);

namespace App\Mailer\Factory;

use App\Mailer\Email\Email;
use App\Mailer\Email\EmailInterface;
use App\Mailer\Exception\EmailCodeNotRegisteredException;

class EmailFactory implements EmailFactoryInterface
{
    /**
     * @param \Traversable<EmailInterface[]> $serviceIterator
     */
    public function __construct(
        private readonly \Traversable $serviceIterator
    ) {
    }

    /**
     * @throws \App\Mailer\Exception\EmailCodeNotRegisteredException
     */
    public function createNew(string $code): Email
    {
        /** @var Email $email */
        foreach (iterator_to_array($this->serviceIterator) as $email) {
            if ($email->getCode() === $code) {
                return $email;
            }
        }

        throw new EmailCodeNotRegisteredException(sprintf('No email was registered with the `%s` code', $code));
    }
}
