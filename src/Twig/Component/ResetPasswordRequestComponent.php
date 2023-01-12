<?php

declare(strict_types=1);

namespace App\Twig\Component;

use Symfony\Component\Form\FormView;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('reset_password_request', 'components/form/reset_password_request.form.twig')]
final class ResetPasswordRequestComponent
{
    public FormView $form;
}
