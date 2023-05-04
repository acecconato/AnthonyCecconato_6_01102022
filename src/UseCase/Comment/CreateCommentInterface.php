<?php

declare(strict_types=1);

namespace App\UseCase\Comment;

use App\Entity\Comment;
use App\Entity\Trick;
use App\Entity\User;

interface CreateCommentInterface
{
    public function __invoke(Comment $comment, Trick $trick, User $user): void;
}
