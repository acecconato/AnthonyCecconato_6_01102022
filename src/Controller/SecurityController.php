<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\ResetPasswordRequest as ResetPasswordRequestEntity;
use App\Entity\User;
use App\Form\Type\ResetPasswordRequestType;
use App\Form\Type\ResetPasswordType;
use App\Form\Type\UserRegistrationType;
use App\UseCase\Security\RegisterInterface;
use App\UseCase\Security\ResetPasswordInterface;
use App\UseCase\Security\ResetPasswordRequestInterface;
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
        if ($this->isGranted('ROLE_USER')) {
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
        $error        = $authenticationUtils->getLastAuthenticationError();
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
        User $user,
        ValidateRegistrationInterface $validateRegistration
    ): Response {
        if ($this->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('app_home');
        }

        $validateRegistration($user);

        $this->addFlash('success', 'Votre compte est désormais actif');

        return $this->redirectToRoute('security_login');
    }

    #[Route('/reinitialisation-du-mot-de-passe', name: 'reset_password_request')]
    public function resetPasswordRequest(
        Request $request,
        ResetPasswordRequestInterface $resetPasswordRequest
    ): Response {
        if ($this->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('app_home');
        }

        $form = $this->createForm(ResetPasswordRequestType::class)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $datas = $form->getData();
            $resetPasswordRequest($datas['email']);

            $this->addFlash(
                'success',
                'Votre demande a bien été prise en compte. 
                Vous devriez recevoir un email vous permettant de réinitialiser votre mot de passe'
            );

            return $this->redirectToRoute('security_login');
        }

        return $this->render('security/reset_password_request.page.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route(
        '/reinitialisation-du-mot-de-passe/{token}',
        name: 'reset_password',
        requirements: [
            'token' => '^[0-9a-fA-F]{8}\b-[0-9a-fA-F]{4}\b-[0-9a-fA-F]{4}\b-[0-9a-fA-F]{4}\b-[0-9a-fA-F]{12}$',
        ]
    )]
    public function resetPassword(
        ResetPasswordRequestEntity $resetPasswordRequest,
        ResetPasswordInterface $resetPassword,
        Request $request
    ): Response {
        if ($this->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('app_home');
        }

        if ($resetPasswordRequest->isExpired()) {
            throw $this->createNotFoundException('Lien expiré');
        }

        $form = $this
            ->createForm(ResetPasswordType::class, $resetPasswordRequest->getUser())
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $resetPassword($resetPasswordRequest);

            $this->addFlash('success', 'Mot de passe modifié, vous pouvez désormais vous connecter');

            return $this->redirectToRoute('security_login');
        }

        return $this->render('security/reset_password.page.twig', ['form' => $form->createView()]);
    }

    #[Route('/logout', name: 'logout')]
    public function logout(): void
    {
    }
}
