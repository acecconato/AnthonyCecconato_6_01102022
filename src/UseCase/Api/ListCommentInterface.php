<?php

declare(strict_types=1);

namespace App\UseCase\Api;

use App\Entity\Comment;
use App\Entity\Trick;

interface ListCommentInterface
{
    /**
     * @return array{
     *    total_items: int,
     *    items_per_page: int,
     *    pages: int,
     *    page: int,
     *    data: array<array-key, Comment>
     * }
     */
    public function __invoke(Trick $trick, int $page = 0): array;
}
