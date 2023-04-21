<?php

declare(strict_types=1);

namespace App\UseCase\Api;

use App\Entity\User;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface UpdateUserAvatarInterface
{
    public function __invoke(UploadedFile $file, User $user): void;
}
