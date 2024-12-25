<?php

namespace Unit\Kernel\Components\Repository\Db;

use DateTime;
use Kernel\Components\Repository\Components\DB\DbEntity;
use Unit\Kernel\Components\Repository\ConvertableEnumMock;

class MockDbEntity extends DbEntity
{
    public const DATE = "2023-11-15 14:22:00";

    public function __construct(
        private string $test = 'test',
        private DateTime $test2 = new DateTime(self::DATE),
        private ConvertableEnumMock $test3 = ConvertableEnumMock::TEST,
        private string|int|null $test4 = null,
        private ConvertableEnumMock $test5 = ConvertableEnumMock::TEST,
    ) {
    }

    /**
     * @return ConvertableEnumMock
     */
    public function getTest5(): ConvertableEnumMock
    {
        return $this->test5;
    }

    /**
     * @return int|string|null
     */
    public function getTest4(): int|string|null
    {
        return $this->test4;
    }

    /**
     * @param ConvertableEnumMock $test5
     */
    public function setTest5(ConvertableEnumMock $test5): void
    {
        $this->test5 = $test5;
    }

    public function setTest4(int|string|null $test4): void
    {
        $this->test4 = $test4;
    }

    public function setTest(string $test): void
    {
        $this->test = $test;
    }

    public function setTest2(DateTime $test2): void
    {
        $this->test2 = $test2;
    }

    public function setTest3(ConvertableEnumMock $test3): void
    {
        $this->test3 = $test3;
    }

    public function getTest(): string
    {
        return $this->test;
    }

    public function getTest2(): DateTime
    {
        return $this->test2;
    }

    public function getTest3(): ConvertableEnumMock
    {
        return $this->test3;
    }
}
