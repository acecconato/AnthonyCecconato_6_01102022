<?php

declare(strict_types=1);

namespace App\UseCase\Comment;

use App\Entity\Comment;
use App\Entity\Trick;
use Symfony\Component\Security\Core\User\UserInterface;

interface CreateCommentInterface
{
    public function __invoke(Comment $comment, Trick $trick, UserInterface $user): void;
}
