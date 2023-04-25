<?php

declare(strict_types=1);

namespace App\UseCase\Api;

use App\Repository\TrickRepository;

class ListTrick implements ListTricksInterface
{
    public function __construct(
        private readonly TrickRepository $repository,
        private readonly int $tricksToShow
    ) {
    }

    public function __invoke(int $page): array
    {
        $tricks = $this->repository->getPaginatedTricks($page);

        $data = [];
        $data['total_items'] = $this->repository->count([]);
        $data['items_per_page'] = $this->tricksToShow;
        $data['pages'] = (int) ceil($data['total_items'] / $this->tricksToShow);
        $data['page'] = $page;

        $data['data'] = $tricks;

        return $data;
    }
}
