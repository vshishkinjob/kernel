<?php

namespace Kernel\Components\Request;

use Psr\Http\Message\ServerRequestInterface;

interface RequestValidatorInterface
{
    public function validate(ServerRequestInterface $request): void;
}
