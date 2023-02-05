<?php

declare(strict_types=1);

namespace App\Uploader;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Uid\Uuid;

class ImageUploader implements FileUploaderInterface
{
    public function __construct(
        private readonly string $uploadDir
    ) {
    }

    public function upload(UploadedFile $file, string $path = null): string
    {
        $targetDir = $this->uploadDir.'/'.$path;
        $fileName = Uuid::v6().'.'.$file->guessExtension();

        $uploadedFile = $file->move($targetDir, $fileName);

        return $uploadedFile->getPathname();
    }

    public function replace(string $oldPath, UploadedFile $file, string $path = null): string
    {
        unlink($oldPath);

        return $this->upload($file, $path);
    }

    public function remove(string $filepath): void
    {
        unlink($filepath);
    }
}
