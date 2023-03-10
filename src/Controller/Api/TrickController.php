<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Repository\TrickRepository;
use App\UseCase\Api\ListTricksInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[Route('/api', name: 'trick_')]
class TrickController extends AbstractController
{
    #[Route('/tricks', name: 'get_collection', methods: [Request::METHOD_GET])]
    public function getCollection(
        ListTricksInterface $listTricks,
        Request $request,
    ): JsonResponse {
        $page = $request->query->getInt('page', 1);

        return $this->json(
            $listTricks($page),
            200,
            ['Content-Type' => 'application/hal+json'],
            ['groups' => ['trick:read']]
        );
    }
}
