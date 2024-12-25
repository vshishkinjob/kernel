<?php

declare(strict_types=1);

namespace Kernel\Components\Repository\Components\DB\TypeCast;

use Kernel\Components\Exception\App\TypeCastException;
use Kernel\Components\Exception\Validation\ValidationException;
use Kernel\ValueObjects\Url;

class UrlTypeCast extends AbstractDbTypeCast
{
    /**
    *
     * @throws ValidationException
     */
    protected function convertToApplicationFormat(mixed $data): Url
    {
        return new Url($data);
    }

    /**
     * @throws TypeCastException
     */
    protected function convertToDbFormat(mixed $data): string
    {
        if (!$data instanceof Url) {
            throw new TypeCastException();
        }

        return $data->url;
    }
}
