<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Repository\UserRepository;
use App\UseCase\Api\UpdateUserAvatarInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api', name: 'api_')]
class ProfileController extends AbstractController
{
    #[Route('/profile/avatar', name: 'update_avatar', methods: ['POST'])]
    public function updateAvatar(
        ValidatorInterface $validator,
        Request $request,
        UpdateUserAvatarInterface $updateUserAvatar,
        UserRepository $repository
    ): JsonResponse {
        $token = $request->headers->get('X-CSRF-TOKEN');

        if (!$this->isCsrfTokenValid('profile', $token)) {
            return $this->json(null, 403);
        }

        $user = $repository->findOneBy(['email' => $this->getUser()->getUserIdentifier()]);

        if (!$user) {
            return $this->json(['error' => 'Vous devez être connecté'], 401);
        }

        $uploadedFile = $request->files->has('file') ? $request->files->get('file') : null;

        if (!$uploadedFile) {
            return $this->json(['error' => 'Le paramètre "file" est manquant'], 422);
        }

        $violations = $validator->validate(
            $uploadedFile,
            new Image([
                'maxHeight' => '500',
                'maxWidth' => '500',
                'maxHeightMessage' => "L'image ne doit pas dépasser 500px de hauteur",
                'maxWidthMessage' => "L'image ne doit pas dépasser 500px de largeur",
                'mimeTypes' => ['image/jpeg', 'image/png', 'image/webp'],
                'mimeTypesMessage' => "Le fichier téléversé n'est pas une image valide",
            ])
        );

        if ($violations->count() > 0) {
            $errors = [];
            foreach ($violations as $violation) {
                $errors[] = $violation->getMessage();
            }

            return $this->json(['error' => implode(', ', $errors)], 422);
        }

        $updateUserAvatar($uploadedFile, $user);

        return $this->json(null, 201);
    }

    #[Route('/profile/delete', name: 'delete_user', methods: ['DELETE'])]
    public function delete(EntityManagerInterface $manager, Security $security, Request $request): JsonResponse
    {
        $token = $request->headers->get('X-CSRF-TOKEN');

        if (!$this->isCsrfTokenValid('profile', $token)) {
            return $this->json(null, 403);
        }

        $user = $this->getUser();

        if (!$user) {
            throw $this->createNotFoundException();
        }

        $manager->remove($user);
        $manager->flush();

        $security->logout(false);

        return $this->json(null, 204);
    }
}
