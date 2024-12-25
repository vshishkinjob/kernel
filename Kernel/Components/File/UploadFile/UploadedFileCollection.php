<?php

declare(strict_types=1);

namespace Kernel\Components\File\UploadFile;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use Traversable;

/**
* @template-implements IteratorAggregate<int, KernelUploadedFileInterface>
 */
class UploadedFileCollection implements IteratorAggregate, Countable
{
    /** @var list<KernelUploadedFileInterface> $files */
    private array $files = [];

    public function add(KernelUploadedFileInterface $file): self
    {
        $this->files[] = $file;
        return $this;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->files);
    }

    public function count(): int
    {
        return count($this->files);
    }
}
