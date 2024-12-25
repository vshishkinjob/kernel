<?php

namespace Unit\Kernel\Components\Repository\Tps\Annotation;

use Codeception\Test\Unit;
use Kernel\Components\Repository\Components\Tps\Annotation\TpsColumn;

class TpsColumnTest extends Unit
{
	public function testGetters()
	{
		$column = new TpsColumn(
            name: 'NAME',
            type: 'TYPE'
        );
        $this->assertEquals('NAME', $column->getName());
        $this->assertEquals('TYPE', $column->getType());
	}
}