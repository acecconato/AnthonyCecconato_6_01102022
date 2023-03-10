<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Trick;
use App\Form\Type\TrickType;
use App\Repository\TrickRepository;
use App\UseCase\Trick\CreateTrickInterface;
use App\UseCase\Trick\DeleteTrickInterface;
use App\UseCase\Trick\UpdateTrickInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrickController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(TrickRepository $trickRepository): Response
    {
        $totalItems = $trickRepository->count([]);
        $tricks = $trickRepository->getPaginatedTricks();

        return $this->render('tricks/home.html.twig', ['tricks' => $tricks, 'total_items' => $totalItems]);
    }

    #[Route('/figures/creation', name: 'app_trick_create')]
    public function createTrick(Request $request, CreateTrickInterface $createTrick): Response
    {
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
        $deleteTrick($trick);

        $this->addFlash('success', 'Figure supprimée');

        return $this->redirectToRoute('app_home');
    }
}
