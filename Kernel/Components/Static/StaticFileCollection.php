<?php

declare(strict_types=1);

namespace Kernel\Components\Static;

use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;
use JsonSerializable;
use Kernel\Components\Exception\App\ForbiddenMethodCallException;
use Kernel\Components\Exception\DB\EntityNotFoundException;
use Traversable;

/**
 * @template-implements IteratorAggregate<int, StaticFile>
 * @template-implements ArrayAccess<int, StaticFile>
 */
final class StaticFileCollection implements IteratorAggregate, Countable, ArrayAccess, JsonSerializable
{
	/** @var list<StaticFile> $files */
	private array $files = [];

	public function add(StaticFile $file): void
	{
		$this->files[] = $file;
	}

	public function getIterator(): Traversable
	{
		return new ArrayIterator($this->files);
	}

	public function count(): int
	{
		return count($this->files);
	}

	public function offsetExists(mixed $offset): bool
	{
		return isset($this->files[$offset]);
	}

	/**
	 * @throws EntityNotFoundException
	 */
	public function offsetGet(mixed $offset): StaticFile
	{
		return $this->files[$offset] ?? throw new EntityNotFoundException(
			"В коллекции отсутствует enum с указанным индексом"
		);
	}

	/**
	 * @throws ForbiddenMethodCallException
	 */
	public function offsetSet(mixed $offset, mixed $value): void
	{
		throw new ForbiddenMethodCallException("Запрещено напрямую переопределять состояние коллекции!");
	}

	/**
	 * @throws ForbiddenMethodCallException
	 */
	public function offsetUnset(mixed $offset): void
	{
		throw new ForbiddenMethodCallException("Запрещено напрямую переопределять состояние коллекции!");
	}

	public function isEmpty(): bool
	{
		return count($this->files) === 0;
	}

    /**
     * @return list<string>
     */
    public function jsonSerialize(): array
    {
        $result = [];
        foreach ($this->files as $file) {
            $result[] = (string) $file;
        }
        return $result;
    }
}
