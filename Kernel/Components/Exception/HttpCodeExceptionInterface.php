<?php

namespace Kernel\Components\Exception;

interface HttpCodeExceptionInterface
{
    public function getHttpStatusCode(): int;
}
