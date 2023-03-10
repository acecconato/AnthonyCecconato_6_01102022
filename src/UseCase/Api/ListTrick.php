<?php

declare(strict_types=1);

namespace App\UseCase\Api;

use App\Repository\TrickRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ListTrick implements ListTricksInterface
{
    public function __construct(
        private readonly TrickRepository $repository,
        private readonly UrlGeneratorInterface $urlGenerator,
        private readonly int $tricksToShow
    ) {
    }

    public function __invoke(int $page): array
    {
        $tricks = $this->repository->getPaginatedTricks($page);

        $data['total_items']    = $this->repository->count([]);
        $data['items_per_page'] = $this->tricksToShow;
        $data['pages']          = (int)ceil($data['total_items'] / $this->tricksToShow);

        $data['data'] = $tricks;

        $links = [
            '_self' => [
                'href'   => $this->urlGenerator->generate(
                    'trick_get_collection',
                    ['page' => $page],
                    UrlGeneratorInterface::ABSOLUTE_URL
                ),
                'method' => Request::METHOD_GET,
            ],
        ];

        if ($page < $data['pages']) {
            $links['next'] = [
                'href'   => $this->urlGenerator->generate(
                    'trick_get_collection',
                    ['page' => $page + 1],
                    UrlGeneratorInterface::ABSOLUTE_URL
                ),
                'method' => Request::METHOD_GET,
            ];
        }

        $data['_links'] = $links;

        return $data;
    }
}
