<?php

namespace Integration\EmailSender;

use App\Entity\User;
use App\Mailer\Email\RegistrationMail;
use App\Mailer\EmailSenderInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Test\MailerAssertionsTrait;
use Symfony\Component\OptionsResolver\Exception\MissingOptionsException;
use Symfony\Component\Uid\Uuid;

class EmailSenderTest extends KernelTestCase
{
    use MailerAssertionsTrait;

    /**
     * @throws \Exception
     */
    public function testSendRegistrationMailSuccess(): void
    {
        self::bootKernel();

        $container = $this->getContainer();

        /** @var EmailSenderInterface $emailSender */
        $emailSender = $container->get(EmailSenderInterface::class);

        $token = Uuid::v6();

        $user = (new User())
            ->setUsername('John')
            ->setEmail('johndoe@demo.fr')
            ->setRegistrationToken($token);

        $emailSender->with(['user' => $user])->send(RegistrationMail::class);

        $email = $this->getMailerMessage();

        $this->assertEmailHtmlBodyContains($email, $token);
    }

    /**
     * @throws \Exception
     */
    public function testSendRegistrationMailMissingOptionsException(): void
    {
        self::bootKernel();

        $container = $this->getContainer();

        /** @var EmailSenderInterface $emailSender */
        $emailSender = $container->get(EmailSenderInterface::class);

        $this->expectException(MissingOptionsException::class);

        $emailSender->send(RegistrationMail::class);
    }

    /**
     * @throws \Exception
     */
    public function testSendRegistrationMailInvalidUserTypeException(): void
    {
        self::bootKernel();

        $container = $this->getContainer();

        $user = 'bad type';

        /** @var EmailSenderInterface $emailSender */
        $emailSender = $container->get(EmailSenderInterface::class);

        $this->expectException(\InvalidArgumentException::class);

        $emailSender->with(['user' => $user])->send(RegistrationMail::class);
    }
}
