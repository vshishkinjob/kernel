<?php

namespace Kernel\Components\File\UploadFile;

interface KernelUploadedFileInterface
{
    public function getFileFullPath(): string;

    public function getFileName(): string;

    /** Возвращает false, если не удалось определить размер файла */
    public function getFileSize(): int|false;

    public function getFileExtension(): string;
}
