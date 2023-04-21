<?php

declare(strict_types=1);

namespace App\UseCase\Api;

use App\Entity\User;
use App\Uploader\FileUploaderInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UpdateUserAvatar implements UpdateUserAvatarInterface
{
    public function __construct(
        private readonly FileUploaderInterface $uploader,
        private readonly EntityManagerInterface $manager
    ) {
    }

    public function __invoke(UploadedFile $file, User $user): void
    {
        if ($user->getAvatar() !== null) {
            $filename = $this->uploader->replace($user->getAvatar(), $file, 'avatar');
        } else {
            $filename = $this->uploader->upload($file, 'avatar');
        }

        $user->setAvatar($filename);

        $this->manager->persist($user);
        $this->manager->flush();
    }
}
