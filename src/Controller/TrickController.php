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

        $video1 = (new Video())->setTitle('video-1')->setUrl('video-1');
        $video2 = (new Video())->setTitle('video-2')->setUrl('video-2');

        $trick->addVideo($video1);
        $trick->addVideo($video2);

        $form = $this->createForm(TrickType::class, $trick)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dd($form);
        }

        return $this->render('tricks/create_trick.page.twig', ['form' => $form->createView()]);
    }
}
