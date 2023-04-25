<?php

declare(strict_types=1);

namespace App\UseCase\Trick;

use App\Entity\Image;
use App\Entity\Trick;
use App\Repository\ImageRepository;
use App\Uploader\FileUploaderInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Path;

class UpdateTrick implements UpdateTrickInterface
{
    public function __construct(
        private readonly FileUploaderInterface $uploader,
        private readonly EntityManagerInterface $manager,
        private readonly Filesystem $fs,
        private readonly ImageRepository $imageRepository
    ) {
    }

    /**
     * @throws \Throwable
     */
    public function __invoke(Trick $trick): void
    {
        $newFiles = [];
        /** @var array<array-key, array{origin: string, temp: string}|null> $deletedFiles */
        $deletedFiles = [];

        try {
            $currentImages = $this->imageRepository->findBy(['trick' => $trick]);

            /* Remove deleted images */
            if ($trick->getImages()->count() < count($currentImages)) {
                /** @var Image[] $diff */
                $diff = array_udiff($currentImages, $trick->getImages()->toArray(), function (Image $a, Image $b): int {
                    if (null === $b->getId() || null === $a->getId()) {
                        return -1;
                    }

                    return $a->getId()->compare($b->getId()) > 0 ? 1 : -1;
                });

                foreach ($diff as $file) {
                    if (null !== $file->getPath()) {
                        $deletedFiles[] = $this->tempDeletedFile(Path::join('img', $file->getPath()));
                        $this->uploader->remove(Path::join('img', $file->getPath()));
                    }
                }
            }

            foreach ($trick->getImages() as $image) {
                // If getUploadedFile isn't set it means that the image hasn't be updated -> continue
                if (null === $image->getUploadedFile()) {
                    continue;
                }

                // If the image's ID is set, it means that it's a new file -> upload
                if (null === $image->getId()) {
                    $webpath = $this->uploader->upload($image->getUploadedFile(), 'img');
                } else { // Else the image already exists -> replace
                    if (null !== $image->getPath()) {
                        $deletedFiles[] = $this->tempDeletedFile(Path::join('img', $image->getPath()));
                        $webpath = $this->uploader->replace($image->getPath(), $image->getUploadedFile(), 'img');
                    }
                }

                if (isset($webpath)) {
                    $newFiles[] = Path::join('img', $webpath);
                    $image->setPath($webpath);
                }
            }

            // Add cover
            if (null !== $trick->getCover() && '' === $trick->getCoverWebPath()) {
                $coverWebpath = $this->uploader->upload($trick->getCover(), 'cover');
                $trick->setCoverWebPath($coverWebpath);
                $newFiles[] = Path::join('cover', $coverWebpath);
            }

            // Update cover
            if (null !== $trick->getCover() && '' !== $trick->getCoverWebPath()) {
                $deletedFiles[] = $this->tempDeletedFile(Path::join('cover', $trick->getCoverWebPath()));
                $coverWebpath = $this->uploader->replace($trick->getCoverWebPath(), $trick->getCover(), 'cover');
                $newFiles[] = Path::join('cover', $coverWebpath);
                $trick->setCoverWebPath($coverWebpath);
            }

            $trick->setUpdatedAt(new \DateTimeImmutable());

            $this->manager->persist($trick);
            $this->manager->flush();
        } catch (\Throwable $e) {
            $this->rollback($newFiles, $deletedFiles);

            throw $e;
        }
    }

    /**
     * @param array<string>                                              $newFiles
     * @param array<array-key, array{origin: string, temp: string}|null> $deletedFiles
     */
    private function rollback(array $newFiles, array $deletedFiles): void
    {
        // Undo created files
        foreach ($newFiles as $file) {
            if (file_exists(Path::join($this->uploader->getUploadDir(), $file))) {
                unlink(Path::join($this->uploader->getUploadDir(), $file));
            }
        }

        // Restore deleted files
        /** @var array{origin: string, temp: string} $file */
        foreach ($deletedFiles as $file) {
            $this->fs->copy($file['temp'], $file['origin']);
            unlink($file['temp']);
        }
    }

    /**
     * @return array{origin: string, temp: string}|null
     */
    private function tempDeletedFile(string $path): ?array
    {
        $tempFullPath = Path::join($this->uploader->getUploadDir(), $path);

        if (file_exists($tempFullPath)) {
            $tempFilename = basename($tempFullPath);
            $tempDirectory = $this->fs->tempnam('/tmp', 'img_');
            // Filesystem won't work without it because it tries to recreate the directory
            unlink($tempDirectory);
            $this->fs->copy($tempFullPath, Path::join($tempDirectory, $tempFilename));

            return ['origin' => $tempFullPath, 'temp' => Path::join($tempDirectory, $tempFilename)];
        }

        return null;
    }
}
