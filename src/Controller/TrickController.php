<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Trick;
use App\Entity\Video;
use App\Form\Type\TrickType;
use App\Repository\TrickRepository;
use App\UseCase\Trick\CreateTrickInterface;
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
        $tricks = $trickRepository->findAll();

        return $this->render('tricks/home.html.twig', ['tricks' => $tricks]);
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

//        $previousImages = array_map(fn(Image $image) => clone $image, $trick->getImages()->getValues());
//        $previousVideos = array_map(fn(Video $video) => clone $video, $trick->getVideos()->getValues());

        if ($form->isSubmitted() && $form->isValid()) {
            $updateTrick($trick);

            $this->addFlash('success', 'Figure modifiée avec succès');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('tricks/edit_trick.html.twig', ['form' => $form->createView(), 'trick' => $trick]);
    }
}
