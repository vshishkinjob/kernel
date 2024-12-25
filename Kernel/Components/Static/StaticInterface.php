<?php

namespace Kernel\Components\Static;

use Kernel\Components\File\UploadFile\KernelUploadedFileInterface;
use Kernel\ValueObjects\Url;

interface StaticInterface
{
    /**
     * @param iterable<KernelUploadedFileInterface> $files
     * @param non-empty-string $remoteFolder
     */
    public function uploadRawFiles(iterable $files, string $remoteFolder): StaticFileCollection;

    /**
     * @param Url $fileUrl
     */
    public function deleteRemoteFile(Url $fileUrl): void;
}
