<?php

namespace Unit\Kernel\Components\Repository\Db;

use Codeception\Test\Unit;
use DateTime;
use Kernel\Components\Exception\App\FunctionNotFoundException;
use Kernel\Components\Exception\App\InvalidReflectionTypeException;
use Unit\Kernel\Components\Repository\ConvertableEnumMock;

class DbEntityTest extends Unit
{
	private MockDbEntity $entity;
	private MockProxyDbEntity $proxyEntity;

	protected function _before(): void
	{
		$this->entity = new MockDbEntity();
		$this->proxyEntity = new MockProxyDbEntity();
	}

	public function testJsonSerialize()
	{
		$data = $this->entity->jsonSerialize();
		$proxyData = $this->proxyEntity->jsonSerialize();

		$this->checkData($data);
		$this->checkData($proxyData);
	}

	public function testDbEntitySuccessfullySetData()
	{
		$entity = new MockDbEntity();

		$data = [
			'test' => 'new_string',
			'test2' => '2023-11-15 14:00:00',
			'test3' => ConvertableEnumMock::TEST2->value,
            'test5' => ConvertableEnumMock::TEST
		];
		$entity->setData($data);
		$this->assertEquals('new_string', $entity->getTest());
		$this->assertEquals('2023-11-15 14:00:00', $entity->getTest2()->format("Y-m-d H:i:s"));
		$this->assertEquals(ConvertableEnumMock::TEST2, $entity->getTest3());
	}

	private function checkData(array $data): void
	{
		$this->assertNotEmpty($data);
		$this->assertEquals('test', $data['test']);
		$this->assertEquals(MockDbEntity::DATE, $data['test2']->format("Y-m-d H:i:s"));
		$this->assertEquals('CONVERTED_VALUE', $data['test3']);
	}

	public function testSetDataFunction()
	{
		$entity = new MockDbEntity();
		$entity->setData(['test' => 'stringType']);
		$this->assertEquals('stringType', $entity->getTest());
	}

	public function testInvalidSetDataFunction()
	{
		$this->expectException(FunctionNotFoundException::class);
		$entity = new MockDbEntity();
		$entity->setData(['notExist' => 'stringType']);
	}

    public function testInvalidReflectionTypeForUnionTypeInParameters()
    {
        $this->expectException(InvalidReflectionTypeException::class);
        $entity = new MockDbEntity();

        $data = [
            'test4' => 'some'
        ];
        $entity->setData($data);
    }
}