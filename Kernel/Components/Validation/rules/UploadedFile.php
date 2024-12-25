<?php

namespace Kernel\Components\Validation\rules;

use Closure;
use Kernel\Components\Validation\handlers\UploadedFileHandler;
use Kernel\Components\Validation\MessageValidationInterface;
use Yiisoft\Validator\EmptyCondition\NeverEmpty;
use Yiisoft\Validator\EmptyCondition\WhenMissing;
use Yiisoft\Validator\EmptyCondition\WhenNull;
use Yiisoft\Validator\Rule\Trait\SkipOnEmptyTrait;
use Yiisoft\Validator\Rule\Trait\WhenTrait;
use Yiisoft\Validator\RuleInterface;
use Yiisoft\Validator\SkipOnEmptyInterface;
use Yiisoft\Validator\WhenInterface;

final class UploadedFile implements RuleInterface, SkipOnEmptyInterface, MessageValidationInterface, WhenInterface
{
    use SkipOnEmptyTrait;
    use WhenTrait;

    /**
    * @param string|list<string>|null $extension
     */
    public function __construct(
        public readonly string $message = 'Передан некорректный файл!',
        public readonly string|array|null $extension = null,
        public readonly ?int $maxSize = null,
        public readonly ?int $minSize = null,
        public readonly WhenMissing|NeverEmpty|WhenNull $skipOnEmpty = new NeverEmpty(),
        public Closure|null $when = null
    ) {
    }

    public function getName(): string
    {
        return 'uploadedFile';
    }

    public function getHandler(): string
    {
        return UploadedFileHandler::class;
    }

    /** @phan-suppress PhanImpossibleTypeComparison */
    public function getMessage(): string
    {
        if (empty($this->extension) && !isset($this->maxSize, $this->minSize)) {
            return 'Ограничение на файл не установлено!';
        }

        $message = 'Файл должен соответствовать следующим характеристикам:';
        if (!empty($this->extension)) {
            $message .= "<br>Допустимые расширения: " . implode(',', (array)$this->extension);
        }
        if ($this->minSize !== null) {
            $message .= "<br>Минимальный размер файла: $this->minSize байт";
        }
        if ($this->maxSize !== null) {
            $message .= "<br>Максимальный размер файла: $this->maxSize байт";
        }
        return $message;
    }

    public function stringMessage(): string
    {
        return "Значение должно быть строкой";
    }
}
