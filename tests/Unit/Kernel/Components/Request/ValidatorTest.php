<?php

namespace Unit\Kernel\Components\Request;

use Codeception\Test\Unit;
use Kernel\Components\Request\RequestValidator;
use Kernel\Components\Request\Validators\JsonRpc\JsonValidator;
use Kernel\Components\Request\Validators\JsonRpc\MethodValidator;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\MiddlewareDispatcher;

class ValidatorTest extends Unit
{
    private MiddlewareInterface $validator;
    private ServerRequestInterface $request;
    private array $result;
    private RequestHandlerInterface $handler;

    protected function _before(): void
    {
        $methodValidator = $this->make(MethodValidator::class, [
            'validate' => function () {
                $this->result['methodValidator'] = 'success!';
            }
        ]);
        $jsonValidator = $this->make(JsonValidator::class, [
            'validate' => function () {
                $this->result['jsonValidator'] = 'success!';
            }
        ]);


        $this->handler = $this->makeEmpty(MiddlewareDispatcher::class);

        $this->request = $this->makeEmpty(ServerRequestInterface::class);

        $this->validator = new RequestValidator([$methodValidator, $jsonValidator]);
    }

    public function testValidate()
    {
        $this->validator->process($this->request, $this->handler);
        $this->assertNotEmpty($this->result);

        foreach ($this->result as $validatorName => $message) {
            $this->assertEquals('success!', $this->result[$validatorName]);
        }

    }
}
