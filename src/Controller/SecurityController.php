<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Form\Type\ResetPasswordRequestType;
use App\Form\Type\UserRegistrationType;
use App\Repository\UserRepository;
use App\UseCase\Security\RegisterInterface;
use App\UseCase\Security\ValidateRegistrationInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

#[Route(name: 'security_')]
class SecurityController extends AbstractController
{
    #[Route('/inscription', name: 'register')]
    public function register(Request $request, RegisterInterface $register): Response
    {
        if ($this->getUser() instanceof UserInterface) {
            return $this->redirectToRoute('app_home');
        }

        $user = new User();

        $form = $this
            ->createForm(UserRegistrationType::class, $user)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $register($user);

            $this->addFlash(
                'success',
                'Compte crée avec succès. Vous allez recevoir un mail vous permettant de valider votre compte'
            );

            return $this->redirectToRoute('security_login');
        }

        return $this->render('security/register.page.twig', ['form' => $form->createView()]);
    }

    #[Route('/connexion', name: 'login')]
    public function login(Request $request, AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser() instanceof UserInterface) {
            return $this->redirectToRoute('app_home');
        }

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.page.twig', ['error' => $error, 'last_username' => $lastUsername]);
    }

    #[Route(
        '/inscription/{registrationToken}/validation',
        name: 'validate_registration',
        requirements: [
            'registrationToken' => '^[0-9a-fA-F]{8}\b-[0-9a-fA-F]{4}\b-[0-9a-fA-F]{4}\b-[0-9a-fA-F]{4}\b-[0-9a-fA-F]{12}$',
        ]
    )]
    public function validateRegistration(
        string $registrationToken,
        ValidateRegistrationInterface $validateRegistration,
        UserRepository $userRepository
    ): Response {
        $user = $userRepository->findOneBy(['registrationToken' => $registrationToken]);

        // Todo Utiliser le paramConverter

        if (null === $user || !$user->hasRegistrationToken()) {
            throw $this->createNotFoundException();
        }

        $validateRegistration($user);

        $this->addFlash('success', 'Votre compte est désormais actif');

        return $this->redirectToRoute('security_login');
    }

    #[Route('/reinitialisation-du-mot-de-passe', name: 'reset_password_request')]
    public function resetPasswordRequest(Request $request): Response
    {
        $resetPassword = new ResetPassword();
        $form = $this->createForm(ResetPasswordRequestType::class, $resetPassword)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Todo
        }

        return $this->render('security/reset_password_request.page.twig', [
            'form' => $form->createView(),
            'resetPassword' => $resetPassword,
        ]);
    }

    #[Route(
        '/reinitialisation-du-mot-de-passe/{token}',
        name: 'reset_password',
        requirements: [
            'token' => '^[0-9a-fA-F]{8}\b-[0-9a-fA-F]{4}\b-[0-9a-fA-F]{4}\b-[0-9a-fA-F]{4}\b-[0-9a-fA-F]{12}$',
        ]
    )]
    public function resetPassword(string $token): Response
    {
    }

    #[Route('/logout', name: 'logout')]
    public function logout(): void
    {
    }
}
