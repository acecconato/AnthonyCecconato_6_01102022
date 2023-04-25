<?php

declare(strict_types=1);

namespace App\UseCase\Trick;

use App\Entity\Trick;
use App\Uploader\FileUploaderInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Path;

class DeleteTrick implements DeleteTrickInterface
{
    public function __construct(
        private readonly FileUploaderInterface $uploader,
        private readonly EntityManagerInterface $manager,
    ) {
    }

    /**
     * @throws \Throwable
     */
    public function __invoke(Trick $trick): void
    {
        foreach ($trick->getImages() as $image) {
            if (null !== $image->getPath()) {
                $this->uploader->remove(Path::join('img', $image->getPath()));
            }
        }

        $this->uploader->remove(Path::join('cover', $trick->getCoverWebPath()));

        $this->manager->remove($trick);
        $this->manager->flush();
    }
}
