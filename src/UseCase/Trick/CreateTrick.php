<?php

declare(strict_types=1);

namespace App\UseCase\Trick;

use App\Entity\Trick;
use App\Uploader\FileUploaderInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class CreateTrick implements CreateTrickInterface
{
    public function __construct(
        private readonly FileUploaderInterface $uploader,
        private readonly EntityManagerInterface $manager
    ) {
    }

    /**
     * @throws \Throwable
     */
    public function __invoke(Trick $trick): void
    {
        try {
            foreach ($trick->getImages() as $image) {
                if ($image->getUploadedFile() !== null) {
                    $webpath = $this->uploader->upload($image->getUploadedFile(), 'img');
                    $image->setPath($webpath);
                }
            }

            if ($trick->getCover() !== null) {
                $webpath = $this->uploader->upload($trick->getCover(), 'cover');
                $trick->setCoverWebPath($webpath);
            }

            $trick->setCreatedAt(new \DateTimeImmutable());

            $this->manager->persist($trick);
            $this->manager->flush();
        } catch (\Throwable $e) {
            foreach ($trick->getImages() as $image) {
                if ($image->getPath() !== null) {
                    $this->uploader->remove($image->getPath());
                }
            }

            $this->uploader->remove($trick->getCoverWebPath());

            throw $e;
        }
    }
}
