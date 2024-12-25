<?php

namespace Kernel\Components\File;

interface ViewRendererInterface
{
    /**
     * @param non-empty-string $filePath
     * @param mixed[] $args
     * @return non-empty-string
     */
    public function renderView(string $filePath, array $args = []): string;
}
