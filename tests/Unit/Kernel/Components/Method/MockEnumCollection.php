<?php

declare(strict_types=1);

namespace Unit\Kernel\Components\Method;

use Kernel\Components\Response\HttpResponseCode;
use Kernel\Enums\EnumCollection;

class MockEnumCollection extends EnumCollection
{
    public function getEnumName(): string
    {
        return HttpResponseCode::class;
    }
}
