<?php

namespace Unit\Kernel\Enums;

use Codeception\Test\Unit;
use Kernel\Components\Exception\App\NotValidEntityException;
use Kernel\Enums\User\SubjectStatus;
use Kernel\Enums\User\SubjectStatusCollection;
use Kernel\Enums\User\SubjectType;
use Kernel\Enums\User\SubjectTypeCollection;
use Kernel\ValueObjects\Email;
use Kernel\ValueObjects\EmailCollection;
use Kernel\ValueObjects\Token;

class EnumCollectionTest extends Unit
{
    public function testAddEnums()
    {
        $collection = (new SubjectTypeCollection())->add(SubjectType::MERCHANT);
        $this->assertCount(1, $collection);
        $collection->addRawValues([SubjectType::USER_UNIDENT->value, SubjectType::SUB_AGENT->value]);
        $this->assertCount(3, $collection);

        $this->assertEquals(
            [SubjectType::MERCHANT->name, SubjectType::USER_UNIDENT->name, SubjectType::SUB_AGENT->name],
            $collection->getAllKeys()
        );
    }

    public function testInvalidEnum()
    {
        $this->expectException(NotValidEntityException::class);
        (new SubjectTypeCollection())->add(SubjectStatus::ACTIVE);
    }
    public function testInvalidInArrayEnum()
    {
        $this->expectException(NotValidEntityException::class);
        (new SubjectTypeCollection())->inArray(SubjectStatus::ACTIVE);
    }


    public function testCreateCollectionForAllCases()
    {
        $except = (new SubjectTypeCollection())->add(SubjectType::MERCHANT);
        $collection = (new SubjectTypeCollection())->createCollectionForAllCases($except);
        $this->assertCount(count(SubjectType::cases()) - 1, $collection);
        $this->assertFalse($collection->inArray(SubjectType::MERCHANT));
    }

    public function testCreateCollectionForAllCasesWithInvalidExcept()
    {
        $this->expectException(NotValidEntityException::class);
        $this->expectExceptionMessage('Некорректная коллекция!');
        $except = new SubjectStatusCollection();
        (new SubjectTypeCollection())->createCollectionForAllCases($except);
    }
}