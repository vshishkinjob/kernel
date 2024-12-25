<?php

declare(strict_types=1);

namespace Kernel\Components\Repository\Components\DB\TypeCast;

use Kernel\Components\Exception\App\TypeCastException;
use Kernel\Components\Exception\Validation\ValidationException;
use Kernel\ValueObjects\Email;

class EmailTypeCast extends AbstractDbTypeCast
{
    /**
     * @throws ValidationException
     */
    protected function convertToApplicationFormat(mixed $data): Email
    {
        return new Email($data);
    }

    /**
     * @throws TypeCastException
     */
    protected function convertToDbFormat(mixed $data): string
    {
        if (!$data instanceof Email) {
            throw new TypeCastException();
        }

        return $data->email;
    }
}
