<?php

namespace Kernel\ValueObjects;

use InvalidArgumentException;
use Kernel\Components\Exception\Validation\ValidationException;
use Kernel\Components\Validation\rules\Color as ColorValidator;
use ReflectionException;
use RuntimeException;
use Yiisoft\Validator\Validator;

/**
 * @template-extends AbstractValueObject<string>
 */
final readonly class Color extends AbstractValueObject
{
    public string $color;

    public function __construct(mixed $value)
    {
        parent::__construct($value);
        /** @var string $value */
        $this->color = $value;
    }

    /**
     * @throws ReflectionException|ValidationException|RuntimeException|InvalidArgumentException
     */
    protected function validate(mixed $value): void
    {
        $rule = new ColorValidator();
        $result = (new Validator())->validate($value, $rule);
        if (!$result->isValid()) {
            throw new ValidationException($rule->getMessage());
        }
    }

    public function getValue(): string
    {
        return $this->color;
    }

    public function isHex(): bool
    {
        return preg_match("/^#([a-fA-F0-9]{3}){1,2}\b$/", $this->color) === 1;
    }

    public function isRGB(): bool
    {
        return preg_match("/^rgb\((\d{1,3}),\s*(\d{1,3}),\s*(\d{1,3})\)$/", $this->color) === 1;
    }

    public function getRGBValue(): string
    {
        if ($this->isRGB()) {
            return $this->color;
        }

        $hex = str_replace("#", "", $this->color);

        // Если формат в короткой форме (3 символа), преобразуем его в длинную форму (6 символов)
        if (strlen($hex) == 3) {
            $hex = str_repeat(substr($hex, 0, 1), 2) .
                str_repeat(substr($hex, 1, 1), 2) .
                str_repeat(substr($hex, 2, 1), 2);
        }

        // Преобразуем значения
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));

        return 'rgb(' . implode(',', [$r, $g, $b]) . ')';
    }

    public function getHexValue(): string
    {
        if ($this->isHex()) {
            return $this->color;
        }

        $values = [];
        preg_match('/rgb\((.*)\)/', $this->color, $values);
        return sprintf("%02x%02x%02x", ...explode(',', $values[1]));
    }
}
