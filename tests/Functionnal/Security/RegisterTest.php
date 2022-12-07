<?php

namespace Functionnal\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\MailerAssertionsTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class RegisterTest extends WebTestCase
{
    use MailerAssertionsTrait;

    public function testShouldRegisterUserAndRedirectToLogin(): void
    {
//        $container = $this->getContainer();
//        $manager = $container->get(EntityManagerInterface::class);
//        $hasher = $container->get(UserPasswordHasherInterface::class);
//
//        /** @var User $user */
//        $user = $manager->getRepository(User::class)->findOneBy(['email' => 'johndoe@demo.fr']);

//
//        $email = $this->getMailerMessage();
//
//        $this->assertEmailHtmlBodyContains($email, (string)$user->getRegistrationToken());
    }

    /**
     * @return array{
     *      'user_registration[email]': string,
     *      'user_registration[username]': string,
     *      'user_registration[plainPassword]': string,
     * }
     */
    public static function createFormData(
        string $email = 'johndoe@demo.fr',
        string $username = 'john',
        string $plainPassword = 'Demo1234!!'
    ): array {
        return [
            'user_registration[email]' => $email,
            'user_registration[username]' => $username,
            'user_registration[plainPassword]' => $plainPassword,
        ];
    }
}
