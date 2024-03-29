<?php

declare(strict_types=1);

namespace App\UseCase\Comment;

use App\Entity\Comment;
use App\Entity\Trick;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CreateComment extends AbstractController implements CreateCommentInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    public function __invoke(Comment $comment, Trick $trick, User $user): void
    {
        $comment->setUser($user);
        $comment->setTrick($trick);
        $comment->setCreatedAt(new \DateTimeImmutable());

        $this->entityManager->persist($comment);
        $this->entityManager->flush();
    }
}
