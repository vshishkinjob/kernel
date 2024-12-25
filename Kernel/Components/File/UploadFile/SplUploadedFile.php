<?php

declare(strict_types=1);

namespace Kernel\Components\File\UploadFile;

use SplFileObject;

class SplUploadedFile extends SplFileObject implements KernelUploadedFileInterface
{
    public function __destruct()
    {
        if (file_exists($this->getPathname())) {
            unlink($this->getPathname());
        }
    }

    public function getFileFullPath(): string
    {
        return $this->getPathname();
    }

    public function getFileSize(): int|false
    {
        return $this->getSize();
    }

    public function getFileExtension(): string
    {
        return $this->getExtension();
    }

    public function getFilename(): string
    {
        return parent::getFilename();
    }
}
