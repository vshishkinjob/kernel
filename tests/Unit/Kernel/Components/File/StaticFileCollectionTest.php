<?php

namespace Unit\Kernel\Components\File;

use Codeception\Test\Unit;
use Kernel\Components\Exception\App\ForbiddenMethodCallException;
use Kernel\Components\Exception\DB\EntityNotFoundException;
use Kernel\Components\Static\StaticFile;
use Kernel\Components\Static\StaticFileCollection;

class StaticFileCollectionTest extends Unit
{
	public function testOffsetGet()
	{
		$collection = new StaticFileCollection();
		$file = $this->make(StaticFile::class);
		$collection->add($file);
		$this->assertInstanceOf(StaticFile::class, $collection->offsetGet(0));
	}

	public function testFailOffsetGet()
	{
		$this->expectException(EntityNotFoundException::class);
		$collection = new StaticFileCollection();
		$collection->offsetGet(0);
	}

	public function testFailOffsetSet()
	{
		$this->expectException(ForbiddenMethodCallException::class);
		$collection = new StaticFileCollection();
		$collection->offsetset(0,0);
	}

	public function testFailOffsetUnset()
	{
		$this->expectException(ForbiddenMethodCallException::class);
		$collection = new StaticFileCollection();
		$collection->offsetUnset(0);
	}
}