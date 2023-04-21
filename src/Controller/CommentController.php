<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Trick;
use App\Form\Type\CommentType;
use App\UseCase\Comment\CreateCommentInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends AbstractController
{
    public function create(
        RequestStack $requestStack,
        CreateCommentInterface $createComment,
        Trick $trick
    ): Response {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $request = $requestStack->getMainRequest();

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $createComment($comment, $trick);
            $this->addFlash('success', 'Commentaire ajouté');
            return $this->redirectToRoute('app_show_trick', ['slug' => $trick->getSlug()]);
        }

        return $this->render('comments/form/_create.html.twig', ['form' => $form->createView()]);
    }
}
