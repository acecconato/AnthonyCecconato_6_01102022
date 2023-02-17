<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Trick;
use App\Form\Type\TrickType;
use App\Repository\TrickRepository;
use App\UseCase\Trick\CreateTrickInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

class TrickController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('tricks/home.page.twig');
    }

    #[Route('/figures/creation', name: 'app_trick_create')]
    public function createTrick(Request $request, CreateTrickInterface $createTrick): Response
    {
        $trick = new Trick();

        $form = $this->createForm(TrickType::class, $trick)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $createTrick($trick);

            $this->addFlash('success', 'Figure ajoutée avec succès');

            return $this->redirectToRoute('app_trick_create');
        }

        return $this->render('tricks/create_trick.page.twig', ['form' => $form->createView()]);
    }

    #[Route('/figures/{id}/modification', name: 'app_trick_update')]
    public function updateTrick($id, TrickRepository $trickRepository): Response
    {
        dd($id, $trickRepository->findOneBy([
            'id' => Uuid::fromString('496568e4-ecfb-1eda-8210-11130166bd3c')->toBinary()
        ]));

        $form = $this->createForm(TrickType::class, $trick)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $createTrick($trick);

            $this->addFlash('success', 'Figure ajoutée avec succès');

            return $this->redirectToRoute('app_trick_create');
        }

        return $this->render('tricks/create_trick.page.twig', ['form' => $form->createView()]);
    }

}
