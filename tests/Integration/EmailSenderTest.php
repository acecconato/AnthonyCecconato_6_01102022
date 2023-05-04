<?php

declare(strict_types=1);

namespace Integration;

use App\Mailer\EmailSenderInterface;
use App\Mailer\Factory\EmailFactoryInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class EmailSenderTest extends KernelTestCase
{
    private ?EmailSenderInterface $sender;

    /**
     * @throws \Exception
     */
    protected function setUp(): void
    {
        self::bootKernel(['environment' => 'test']);
        //        $this->sender = self::getContainer()->get(EmailSenderInterface::class);
    }

    /**
     * @throws \Exception
     */
    public function testSendEmailWithoutOptions(): void
    {
        $this->sender->send('test_without_data', ['test@test.com']);

        $email = $this->getMailerMessage();

        self::assertEmailHtmlBodyContains($email, 'Hello World!');
    }

    public function testTest(): void
    {
        dd(self::getContainer()->get(EmailFactoryInterface::class));
    }
}
