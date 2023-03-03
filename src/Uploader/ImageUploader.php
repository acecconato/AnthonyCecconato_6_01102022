<?php

declare(strict_types=1);

namespace App\Uploader;

use Symfony\Component\Filesystem\Path;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageUploader implements FileUploaderInterface
{
    public function __construct(
        private readonly string $uploadDir
    ) {
    }

    public function upload(UploadedFile $file, string $path = null): string
    {
        $targetDir = $this->uploadDir.'/'.$path;
        $filename = uniqid().'.'.$file->guessExtension();

        $file->move($targetDir, $filename);

        return $filename;
    }

    public function replace(string $oldFilename, UploadedFile $file, string $path = null): string
    {
        $oldFile = Path::normalize($this->uploadDir.'/'.$path.'/'.$oldFilename);

        if (file_exists($oldFile)) {
            unlink($oldFile);
        }

        return $this->upload($file, $path);
    }

    public function remove(string $filepath): void
    {
        if (file_exists($this->uploadDir.'/'.$filepath)) {
            unlink($this->uploadDir.'/'.$filepath);
        }
    }

    public function getUploadDir(): string
    {
        return $this->uploadDir;
    }
}
