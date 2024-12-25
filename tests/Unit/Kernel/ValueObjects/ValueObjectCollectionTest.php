<?php

namespace Unit\Kernel\ValueObjects;

use Codeception\Test\Unit;
use Kernel\Components\Exception\App\NotValidEntityException;
use Kernel\ValueObjects\Email;
use Kernel\ValueObjects\EmailCollection;
use Kernel\ValueObjects\Url;

class ValueObjectCollectionTest extends Unit
{
    public function testImmutability()
    {
        $base = (new EmailCollection())->add(new Email('test@test.test'));
        $newBase = $base->add(new Email('test2@test.test'));
        $newNewBase = $base->addRawValues(['test3@test.test', 'test4@test.test']);

        $this->assertCount(1, $base);
        $this->assertCount(2, $newBase);
        $this->assertCount(3, $newNewBase);
    }

    public function testInArray()
    {
        $collection = (new EmailCollection())->addRawValues(['test3@test.test', 'test4@test.test']);

        $this->assertTrue($collection->inArray(new Email('test3@test.test')));
        $this->assertFalse($collection->inArray(new Email('test2@test.test')));
    }

    public function testUnique()
    {
        $collection = (new EmailCollection())->addRawValues(['test3@test.test', 'test4@test.test', 'test4@test.test']);
        $this->assertCount(3, $collection->getAllValues());
        $this->assertCount(2, $collection->getUniqueValues());
    }

    public function testInvalidValueObjectType()
    {
        $this->expectException(NotValidEntityException::class);
        (new EmailCollection())->add(new Url('https://google.com'));
    }

    public function testInvalidInArrayValueObjectType()
    {
        $this->expectException(NotValidEntityException::class);
        $collection = new EmailCollection();
        $collection->inArray(new Url('https://google.com'));
    }
}