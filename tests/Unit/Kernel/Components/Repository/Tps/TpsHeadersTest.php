<?php

namespace Unit\Kernel\Components\Repository\Tps;

use Codeception\Test\Unit;
use Kernel\Components\Repository\Components\Tps\TpsHeaders;
use Kernel\Components\Request\ServerSuperGlobalHelper;
use Kernel\ValueObjects\AppUniqueId;
use Kernel\ValueObjects\Token;

class TpsHeadersTest extends Unit
{
	public function testGetDefaultHeaders()
	{
		$token = new Token('test token');
		$uniqueId = new AppUniqueId();
		$tpsHeaders = new TpsHeaders($token, $uniqueId);
		$result = $tpsHeaders->getRepositoryHeaders();
		$this->assertEquals($token->getValue(), $result['secret-key']);
		$this->assertEquals(ServerSuperGlobalHelper::getUserHostAddress(), $result['client-ip']);
		$this->assertEquals($uniqueId->getValue(), $result['wsdl-request']);
		$this->assertEquals('Keep-Alive',$result['Connection']);
	}
}