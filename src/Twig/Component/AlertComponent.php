<?php

namespace App\Twig\Component;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('alert', template: '/components/design/alert.design.twig')]
class AlertComponent
{
    public string $type = 'danger';
    public string $message = 'No message defined';
}
