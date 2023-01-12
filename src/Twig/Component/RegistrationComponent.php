<?php

declare(strict_types=1);

namespace App\Twig\Component;

use Symfony\Component\Form\FormView;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('registration', 'components/form/registration.form.twig')]
final class RegistrationComponent
{
    public FormView $form;
}
