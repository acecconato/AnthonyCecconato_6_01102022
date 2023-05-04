<?php

declare(strict_types=1);

namespace App\Twig\Component;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('alert', template: '/components/design/alert.html.twig')]
class AlertComponent
{
    public string $type = 'danger';
    public string $message = 'No message defined';
}
