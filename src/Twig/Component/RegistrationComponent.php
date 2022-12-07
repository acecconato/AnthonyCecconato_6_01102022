<?php

namespace App\Twig\Component;

use App\Entity\User;
use App\Form\Type\UserRegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('registration', 'components/form/registration.form.twig')]
final class RegistrationComponent extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;

    public ?User $user = null;

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(UserRegistrationType::class, $this->user);
    }
}
