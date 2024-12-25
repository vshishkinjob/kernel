<?php

namespace Unit\Kernel\Components\Request;

use Codeception\Test\Unit;
use Kernel\Components\Request\HttpRequestProtocols\RequestProtocolInterface;
use Kernel\Components\Request\KernelRequest;
use Kernel\ValueObjects\Token;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UploadedFileInterface;
use Psr\Http\Message\UriInterface;

class KernelRequestTest extends Unit
{
   public function testKernelRequestCreation()
   {
       $_SERVER['CONTENT_TYPE'] = 'CONTENT-TYPE-HEADER_VALUE';

       $request = $this->makeEmpty(ServerRequestInterface::class, [
           'getMethod' => 'SOME_METHOD',
           'getUri' => $this->makeEmpty(UriInterface::class, [
               'getHost' => 'SOME_HOST'
           ]),
           'getServerParams' => ['SERVER_PARAMS'],
           'getBody' => $this->makeEmpty(StreamInterface::class),
           'getUploadedFiles' => [$this->makeEmpty(UploadedFileInterface::class)]
       ]);

       $protocol = $this->makeEmpty(RequestProtocolInterface::class, [
           'init' => $this->makeEmpty(RequestProtocolInterface::class, [
               'getMethodClassName' => 'METHOD_CLASS_NAME',
               'getMethodParams' => ['PARAM' => 'SOME_VALUE']
           ])
       ]);

       $kernel = new KernelRequest(
           $request,
           $protocol,
           new Token('SOME_TOKEN')
       );

       $this->assertEquals('SOME_METHOD', $kernel->getMethod());
       $this->assertEquals(['CONTENT-TYPE-HEADER_VALUE'], $kernel->getHeader('content-type'));
       $this->assertEquals(['PARAM' => 'SOME_VALUE'], $kernel->getMethodParams());
       $this->assertEquals(['SERVER_PARAMS'], $kernel->getServerParams());
       $this->assertCount(1, $kernel->getUploadedFiles());
       $this->assertInstanceOf(UploadedFileInterface::class, $kernel->getUploadedFiles()[0]);

       unset($_SERVER['CONTENT_TYPE']);
   }
}
