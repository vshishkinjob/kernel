<?php

namespace Kernel\Components\File;

interface FileSaveInterface
{
    /**
     * @param non-empty-string $filename
     */
    public function save(string $filename): void;

    public function setWriter(WriteInterface $writer): void;
}
