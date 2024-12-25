<?php

namespace Kernel\Components\Validation\handlers;

use Kernel\Components\Exception\Exception;
use Kernel\Components\File\FileHelper;
use Kernel\Components\File\UploadFile\KernelUploadedFileInterface;
use Kernel\Components\File\UploadFile\PsrUploadedFile;
use Kernel\Components\Validation\rules\Base64;
use Kernel\Components\Validation\rules\UploadedFile;
use LogicException;
use Psr\Http\Message\UploadedFileInterface;
use ReflectionException;
use RuntimeException;
use Yiisoft\Validator\Exception\UnexpectedRuleException;
use Yiisoft\Validator\Result;
use Yiisoft\Validator\RuleHandlerInterface;
use Yiisoft\Validator\ValidationContext;

final readonly class UploadedFileHandler implements RuleHandlerInterface
{
    public function __construct(private FileHelper $fileHelper)
    {
    }

    /**
     * @throws UnexpectedRuleException
     * @throws LogicException
     * @throws RuntimeException
     * @throws ReflectionException
     */
    public function validate(mixed $value, object $rule, ValidationContext $context): Result
    {
        if (!$rule instanceof UploadedFile) {
            throw new UnexpectedRuleException(UploadedFile::class, $rule);
        }

        if (!(is_string($value) || $value instanceof UploadedFileInterface)) {
            return (new Result())->addError(
                "Некорректный формат файла!",
                ['attribute' => $context->getTranslatedAttribute()]
            );
        }

        if (is_string($value)) {
            return $this->validateBase64File($value, $rule, $context);
        }
        return $this->validatePsrUploadedFile($value, $rule, $context);
    }

    /**
     * @param string $value
     * @param UploadedFile $rule
     * @return Result
     * @throws ReflectionException
     * @throws RuntimeException
     * @throws LogicException
     */
    private function validateBase64File(string $value, UploadedFile $rule, ValidationContext $context): Result
    {
        try {
            $file = $this->fileHelper->getFileObjectFromBase64($value);
        } catch (Exception $exception) {
            return (new Result())->addError(
                "Не удалось создать файл из Base64 строки!",
                ['attribute' => $context->getTranslatedAttribute()]
            );
        }
        return $this->validateFileParams($file, $rule, $context);
    }

    private function validatePsrUploadedFile(
        UploadedFileInterface $value,
        UploadedFile $rule,
        ValidationContext $context
    ): Result {
        $file = new PsrUploadedFile($value);
        return $this->validateFileParams($file, $rule, $context);
    }

    private function validateFileParams(
        KernelUploadedFileInterface $file,
        UploadedFile $rule,
        ValidationContext $context
    ): Result {
        $result = new Result();
        if (!empty($rule->extension) && !in_array($file->getFileExtension(), (array)$rule->extension, true)) {
            $result->addError(
                "Файл должен быть в формате: " . implode(',', (array)$rule->extension),
                ['attribute' => $context->getTranslatedAttribute()]
            );
        }

        if (($rule->minSize !== null || $rule->maxSize !== null) && $file->getFileSize() === false) {
            return $result->addError(
                "Не удалось определить размер файла!",
                ['attribute' => $context->getTranslatedAttribute()]
            );
        }

        if ($rule->minSize !== null && $file->getFileSize() < $rule->minSize) {
            $result->addError(
                "Файл должен быть не менее $rule->minSize байт",
                ['attribute' => $context->getTranslatedAttribute()]
            );
        }

        if ($rule->maxSize !== null && $file->getFileSize() > $rule->maxSize) {
            $result->addError(
                "Файл должен быть не более $rule->maxSize байт",
                ['attribute' => $context->getTranslatedAttribute()]
            );
        }

        return $result;
    }
}
