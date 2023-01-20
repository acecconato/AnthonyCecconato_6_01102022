<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Trick;
use App\Entity\Video;
use App\Form\Type\TrickType;
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

    #[Route('/figures/creation')]
    public function createTrick(Request $request): Response
    {
        $trick = new Trick();

        $form = $this->createForm(TrickType::class, $trick)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dd($form);
        }

        return $this->render('tricks/create_trick.page.twig', ['form' => $form->createView()]);
    }
}
