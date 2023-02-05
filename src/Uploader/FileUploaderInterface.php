<?php

declare(strict_types=1);

namespace App\Uploader;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface FileUploaderInterface
{
    public function upload(UploadedFile $file, string $path = null): string;

    public function replace(string $oldPath, UploadedFile $file, string $path = null): string;

    public function remove(string $filepath): void;
}
