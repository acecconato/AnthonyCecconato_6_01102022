<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Entity\Trick;
use App\UseCase\Api\ListCommentInterface;
use App\UseCase\Api\ListTricksInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'trick_')]
class TrickController extends AbstractController
{
    #[Route('/tricks', name: 'get_collection', methods: [Request::METHOD_GET])]
    public function getCollection(
        ListTricksInterface $listTricks,
        Request $request,
    ): JsonResponse {
        $page = max($request->query->getInt('page'), 0);

        return $this->json(
            $listTricks($page),
            200,
            ['Content-Type' => 'application/json'],
            ['groups' => ['trick:read']]
        );
    }

    #[Route('/tricks/{slug}/comments', name: 'get_comments', requirements: ['slug' => '[a-zA-Z0-9_-]+'], methods: [Request::METHOD_GET])]
    public function getComments(Request $request, Trick $trick, ListCommentInterface $listComment): JsonResponse
    {
        $page = $request->query->getInt('page', 1);

        return $this->json(
            $listComment($trick, $page),
            200,
            ['Content-Type' => 'application/json'],
            ['groups' => 'comment:read']
        );
    }
}
