<?php

declare(strict_types=1);

namespace App\UseCase\Comment;

use App\Entity\Comment;
use App\Entity\Trick;
use Symfony\Component\Security\Core\User\UserInterface;

interface CreateCommentInterface
{
    /**
     * @param \Symfony\Component\Security\Core\User\UserInterface|null $user Retrieve the current user if set to null
     */
    public function __invoke(Comment $comment, Trick $trick, UserInterface $user = null): void;
}
