<?php

namespace Unit\Kernel\Components\Repository;

use Codeception\Test\Unit;
use Kernel\Components\Repository\Components\BaseEntity;

class BaseEntityTest extends Unit
{
    private BaseEntity $entity;

    protected function _before(): void
    {
        $this->entity = new class extends BaseEntity {
            private string $test = 'test';
            private string $test2 = 'test2';
            private ConvertableEnumMock $test3 = ConvertableEnumMock::TEST;
        };
    }

    public function testJsonSerialize()
    {
        $data = $this->entity->jsonSerialize();
        $this->checkData($data);
    }

    public function testAsArray()
    {
        $data = $this->entity->asArray();
        $this->checkData($data);
    }

    private function checkData(array $data): void
    {
        $this->assertNotEmpty($data);
        $this->assertEquals('test', $data['test']);
        $this->assertEquals('test2', $data['test2']);
        $this->assertEquals('CONVERTED_VALUE', $data['test3']);

        $data = json_encode($data);

        $this->assertJson($data);
    }
}
