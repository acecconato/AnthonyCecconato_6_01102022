<?php

declare(strict_types=1);

namespace App\UseCase\Api;

use App\Entity\Trick;

interface ListTricksInterface
{
    /**
     * @return array{
     *    total_items: int,
     *    items_per_page: int,
     *    pages: int,
     *    page: int,
     *    data: array<array-key, Trick>
     * }
     */
    public function __invoke(int $page): array;
}
