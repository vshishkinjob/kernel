<?php

declare(strict_types=1);

namespace Unit\Kernel\Components\Method\MockDTO;

use Kernel\Components\File\UploadFile\KernelUploadedFileInterface;
use Kernel\Components\File\UploadFile\UploadedFileCollection;
use Kernel\Components\Method\AbstractDTO;
use Kernel\Components\Response\HttpResponseCode;
use Kernel\Components\Validation\rules\BooleanType;
use Kernel\Components\Validation\rules\DateRange as DateRangeValidator;
use Kernel\Components\Validation\rules\IntegerType;
use Kernel\Components\Validation\rules\Pagination as PaginationValidator;
use Kernel\Components\Validation\rules\UploadedFile;
use Kernel\Enums\User\SubjectType;
use Kernel\ValueObjects\DateRange;
use Kernel\ValueObjects\Email;
use Kernel\ValueObjects\EmailCollection;
use Kernel\ValueObjects\Pagination;
use Unit\Kernel\Components\Method\MockEnumCollection;
use Yiisoft\Validator\EmptyCondition\WhenMissing;
use Yiisoft\Validator\Rule\Each;
use Yiisoft\Validator\Rule\Email as EmailValidator;
use Yiisoft\Validator\Rule\In;
use Yiisoft\Validator\Rule\StringValue;

class CorrectDto extends AbstractDTO
{
    public int|null $field;
    public string $string;
    public KernelUploadedFileInterface $file;
    public UploadedFileCollection $files;
    public SubjectType $type;
    public MockEnumCollection $enumCollection;
    public Email $email;
    public EmailCollection $emailCollection;
    public DateRange $dateRange;
    public Pagination $pagination;
    public array $array;
    public int $integerString;
    public float $floatString;
    public bool $bool;

    protected function rules(): array
    {
        return [
            'field' => new IntegerType(skipOnEmpty: new WhenMissing()),
            'string' => new StringValue(skipOnEmpty: new WhenMissing()),
            'file' => new UploadedFile(extension: 'png', skipOnEmpty: new WhenMissing()),
            'files' => new Each(new UploadedFile(), skipOnEmpty: new WhenMissing()),
            'type' => new IntegerType(skipOnEmpty: new WhenMissing()),
            'enumCollection' => new Each(new In(HttpResponseCode::getValuesAsArray(), strict: true), skipOnEmpty: new WhenMissing()),
            'array' => new Each(new StringValue(), skipOnEmpty: new WhenMissing()),
            'integerString' => new StringValue(skipOnEmpty: new WhenMissing()),
            'floatString' => new StringValue(skipOnEmpty: new WhenMissing()),
            'bool' => new BooleanType(skipOnEmpty: new WhenMissing()),
            'email' => new EmailValidator(skipOnEmpty: new WhenMissing()),
            'emailCollection' => new Each(new EmailValidator(), skipOnEmpty: new WhenMissing()),
            "dateRange" => new DateRangeValidator(format: "Y-m-d", skipOnEmpty: new WhenMissing()),
            'pagination' => new PaginationValidator(skipOnEmpty: new WhenMissing())
        ];
    }
}