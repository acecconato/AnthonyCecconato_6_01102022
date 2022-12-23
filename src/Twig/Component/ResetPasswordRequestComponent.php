<?php

declare(strict_types=1);

namespace App\Twig\Component;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('reset_password_request', 'components/form/reset_password_request.form.twig')]
final class ResetPasswordRequestComponent extends AbstractController
{
    // todo delete
}
