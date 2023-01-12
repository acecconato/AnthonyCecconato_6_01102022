<?php

declare(strict_types=1);

namespace App\Twig\Component;

use Symfony\Component\Form\FormView;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('reset_password', 'components/form/reset_password.form.twig')]
final class ResetPasswordComponent
{
    public FormView $form;
}
