<?php

declare(strict_types=1);

namespace App\UseCase\Api;

use App\Entity\Trick;
use App\Repository\CommentRepository;

class ListComment implements ListCommentInterface
{
    public function __construct(
        private readonly CommentRepository $repository,
        private readonly int $nbCommentsToShow
    ) {
    }

    public function __invoke(Trick $trick, int $page = 0): array
    {
        $comments = $this->repository->getPaginatedComments($trick, $page);

        $data['total_items'] = $this->repository->count(['trick' => $trick]);
        $data['items_per_page'] = $this->nbCommentsToShow;
        $data['pages'] = (int) ceil($data['total_items'] / $this->nbCommentsToShow);
        $data['page'] = $page;

        $data['data'] = $comments;

        return $data;
    }
}
