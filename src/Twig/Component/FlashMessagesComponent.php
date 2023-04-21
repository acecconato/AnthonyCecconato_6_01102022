<?php

declare(strict_types=1);

namespace App\Twig\Component;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('flash_messages', template: '/components/design/flash_message.html.twig')]
class FlashMessagesComponent
{
}
