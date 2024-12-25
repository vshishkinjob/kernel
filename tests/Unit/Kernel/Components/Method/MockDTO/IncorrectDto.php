<?php

declare(strict_types=1);

namespace Unit\Kernel\Components\Method\MockDTO;

use Kernel\Components\File\UploadFile\KernelUploadedFileInterface;
use Kernel\Components\Method\AbstractDTO;
use Kernel\Components\Validation\rules\BooleanType;
use Kernel\Components\Validation\rules\IntegerType;
use Kernel\Components\Validation\rules\UploadedFile;
use Yiisoft\Validator\EmptyCondition\WhenMissing;
use Yiisoft\Validator\Rule\StringValue;

class IncorrectDto extends AbstractDTO
{
    public int $field;
    public bool $field2;
    public KernelUploadedFileInterface $file;
    public string|int|null $unionType;
    public string $notAString;
    public array $notAnArray;
    public int $notAnIntegerString;
    public float $notAnFloatString;
    public bool $notAnBool;

    protected function rules(): array
    {
        return [
            'field' => new IntegerType(skipOnEmpty: new WhenMissing()),
            'field2' => new BooleanType(skipOnEmpty: new WhenMissing()),
            'file' => new UploadedFile(skipOnEmpty: new WhenMissing()),
            'unionType' => new StringValue(skipOnEmpty: new WhenMissing()),
            'notAString' => new IntegerType(skipOnEmpty: new WhenMissing()),
            'notAnArray' => new IntegerType(skipOnEmpty: new WhenMissing()),
            'notAnIntegerString' => new StringValue(skipOnEmpty: new WhenMissing()),
            'notAnFloatString' => new StringValue(skipOnEmpty: new WhenMissing()),
            'notAnBool' => new StringValue(skipOnEmpty: new WhenMissing())
        ];
    }
}