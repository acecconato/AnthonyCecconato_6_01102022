<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Trick;
use App\Form\Type\TrickType;
use App\Repository\CommentRepository;
use App\Repository\TrickRepository;
use App\UseCase\Trick\CreateTrickInterface;
use App\UseCase\Trick\DeleteTrickInterface;
use App\UseCase\Trick\UpdateTrickInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Path;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class TrickController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(
        TrickRepository $trickRepository,
        UrlGeneratorInterface $urlGenerator,
        string $uploadDir
    ): Response {
        $totalItems = $trickRepository->count([]);
        $tricks     = $trickRepository->getPaginatedTricks();

        $routes = [
            'update' => $urlGenerator->generate(
                'app_trick_update',
                ['slug' => 'js_placeholder'],
                UrlGeneratorInterface::ABSOLUTE_URL
            ),
            'delete' => $urlGenerator->generate(
                'app_trick_delete',
                ['slug' => 'js_placeholder'],
                UrlGeneratorInterface::ABSOLUTE_URL
            ),
        ];

        return $this->render(
            'tricks/home.html.twig',
            [
                'tricks' => $tricks,
                'total_items' => $totalItems,
                'routes' => $routes,
                'cover_path' => Path::getFilenameWithoutExtension($uploadDir) . '/cover',
            ]
        );
    }

    #[Route('/figures/creation', name: 'app_trick_create')]
    public function createTrick(Request $request, CreateTrickInterface $createTrick): Response
    {
        if ( ! $this->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $trick = new Trick();

        $form = $this->createForm(TrickType::class, $trick, ['validation_groups' => ['Default', 'create']])
                     ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $createTrick($trick);

            $this->addFlash('success', 'Figure ajoutée avec succès');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('tricks/create_trick.html.twig', ['form' => $form->createView(), 'trick' => $trick]);
    }

    #[Route('/figures/{slug}/modification', name: 'app_trick_update', requirements: ['slug' => '[a-zA-Z0-9_-]+'])]
    public function updateTrick(Trick $trick, Request $request, UpdateTrickInterface $updateTrick): Response
    {
        if ( ! $this->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $form = $this
            ->createForm(TrickType::class, $trick, ['validation_groups' => 'Default'])
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $updateTrick($trick);

            $this->addFlash('success', 'Figure modifiée avec succès');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('tricks/edit_trick.html.twig', ['form' => $form->createView(), 'trick' => $trick]);
    }

    #[Route('/figures/{slug}/supprimer', name: 'app_trick_delete', requirements: ['slug' => '[a-zA-Z0-9_-]+'])]
    public function deleteTrick(Trick $trick, DeleteTrickInterface $deleteTrick): Response
    {
        if ( ! $this->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $deleteTrick($trick);

        $this->addFlash('success', 'Figure supprimée');

        return $this->redirectToRoute('app_home');
    }

    #[Route('/figures/{slug}', name: 'app_show_trick', requirements: ['slug' => '[a-zA-Z0-9_-]+'])]
    public function showTrick(Trick $trick, CommentRepository $repository): Response
    {
        return $this->render('tricks/show_trick.html.twig', ['trick' => $trick]);
    }
}
