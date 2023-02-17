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
        $filename = Uuid::v6().'.'.$file->guessExtension();

        $file->move($targetDir, $filename);

        return $filename;
    }

    public function replace(string $oldPath, UploadedFile $file, string $path = null): string
    {
        if (file_exists($this->uploadDir.'/'.$oldPath)) {
            unlink($this->uploadDir.'/'.$oldPath);
        }

        return $this->upload($file, $path);
    }

    public function remove(string $filepath): void
    {
        if (file_exists($this->uploadDir.'/'.$filepath)) {
            unlink($this->uploadDir.'/'.$filepath);
        }
    }
}
