<?php

namespace Kernel\Components\File;

interface FileWorkerInterface
{
    /**
     * @return non-empty-string
     */
    public function create(ReportData $data): string;

    /**
     * @param non-empty-string $filename
     * @return mixed[]
     */
    public function read(string $filename): array;

    /**
     * @param non-empty-string $fileLocation
     * @param non-empty-string $filename
     */
    public function send(string $fileLocation, string $filename): void;

    /**
     * @param non-empty-string $fileLocation
     */
    public function save(string $fileLocation): void;
}
