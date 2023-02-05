<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Trick;
use App\Form\Type\TrickType;
use App\UseCase\Trick\CreateTrickInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
}
