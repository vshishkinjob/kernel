<?php

namespace Kernel\Components\Validation\handlers;

use Kernel\Components\Validation\rules\Color;
use Yiisoft\Validator\Exception\UnexpectedRuleException;
use Yiisoft\Validator\Result;
use Yiisoft\Validator\RuleHandlerInterface;
use Yiisoft\Validator\ValidationContext;

final class ColorHandler implements RuleHandlerInterface
{
    /**
     * @throws UnexpectedRuleException
     */
    public function validate(mixed $value, object $rule, ValidationContext $context): Result
    {
        if (!$rule instanceof Color) {
            throw new UnexpectedRuleException(Color::class, $rule);
        }
        if (!is_string($value)) {
            return (new Result())->addError(
                $rule->stringMessage(),
                ['attribute' => $context->getTranslatedAttribute()]
            );
        }

        $isColor = $this->isColor($value, $rule);
        $result = new Result();

        if (!$isColor) {
            $result->addError($rule->getMessage(), ['attribute' => $context->getTranslatedAttribute()]);
        }
        return $result;
    }

    /** format of color: rgb(255,255,255)*/
    private function isRgb(string $value): bool
    {
        return preg_match("/^rgb\((\d{1,3}),\s*(\d{1,3}),\s*(\d{1,3})\)$/", $value) === 1;
    }

    /** format of color: #f12 or #FFF333*/
    private function isHex(string $value): bool
    {
        return preg_match("/^#([a-fA-F0-9]{3}){1,2}\b$/", $value) === 1;
    }

    private function isColor(string $value, Color $rule): bool
    {
        $isHex = $this->isHex($value);
        $isRgb = $this->isRgb($value);

        if ($rule->hex === $rule->rgb) {
            return $isHex || $isRgb;
        }

        return $rule->hex ? $isHex : $isRgb;
    }
}
