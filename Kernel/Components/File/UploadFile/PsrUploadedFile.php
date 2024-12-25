<?php

declare(strict_types=1);

namespace Kernel\Components\File\UploadFile;

use Kernel\Components\Exception\File\IncorrectFileFormatException;
use Kernel\Components\File\FileHelper;
use Psr\Http\Message\UploadedFileInterface as PsrUploadedFileInterface;
use RuntimeException;

final readonly class PsrUploadedFile implements KernelUploadedFileInterface
{
    public function __construct(private PsrUploadedFileInterface $file)
    {
    }

	/**
	 * @throws RuntimeException
	 */
    public function getFileFullPath(): string
    {
        /** @var string $path */
        $path = $this->file->getStream()->getMetadata('uri');
        return $path;
    }

    public function getFileSize(): int|false
    {
        return $this->file->getSize() ?? false;
    }

	/**
	 * @throws IncorrectFileFormatException
	 * @throws RuntimeException
	 */
    public function getFileExtension(): string
    {
        return $this->getFileHelper()->getExtensionFromPath($this->getFileFullPath());
    }

    public function getFileName(): string
    {
        return $this->file->getClientFilename() ?? '';
    }

    private function getFileHelper(): FileHelper
    {
        return new FileHelper();
    }
}
