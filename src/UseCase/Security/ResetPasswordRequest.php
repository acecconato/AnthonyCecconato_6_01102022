<?php

declare(strict_types=1);

namespace App\UseCase\Security;

use App\Entity\ResetPasswordRequest as ResetPasswordRequestEntity;
use App\Mailer\EmailSenderInterface;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mime\Address;
use Symfony\Component\Uid\Uuid;

class ResetPasswordRequest extends AbstractController implements ResetPasswordRequestInterface
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly EntityManagerInterface $entityManager,
        private readonly EmailSenderInterface $emailSender
    ) {
    }

    /**
     * @throws \Throwable
     */
    public function __invoke(string $email): void
    {
        $user = $this->userRepository->findOneBy(['email' => $email]);

        if (null === $user) {
            return;
        }

        $resetPaswordRequest = new ResetPasswordRequestEntity();
        $now = new \DateTimeImmutable();

        $resetPaswordRequest
            ->setUser($user)
            ->setToken(Uuid::v6())
            ->setCreatedAt($now)
            ->setExpiresAt($now->modify('+1 hour'));

        $this->entityManager->beginTransaction();

        $this->entityManager->persist($resetPaswordRequest);
        $this->entityManager->flush();

        try {
            $this->emailSender->send(
                'reset_password',
                new Address($user->getEmail(), $user->getUsername()),
                ['resetPasswordRequest' => $resetPaswordRequest]
            );
            $this->entityManager->commit();
        } catch (\Throwable $e) {
            $this->entityManager->rollback();
            throw $e;
        }
    }
}
