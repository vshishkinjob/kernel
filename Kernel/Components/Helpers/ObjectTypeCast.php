<?php

declare(strict_types=1);

namespace Kernel\Components\Helpers;

use BackedEnum;
use DateTime;
use DateTimeImmutable;
use Exception;
use Kernel\Components\Exception\App\NotValidEntityException;
use Kernel\Components\Exception\App\TypeCastException;
use Kernel\Components\Exception\File\FileNotFoundException;
use Kernel\Components\Exception\File\FilePermissionDeniedException;
use Kernel\Components\Exception\File\IncorrectFileFormatException;
use Kernel\Components\Exception\File\UndefinedMimeTypeException;
use Kernel\Components\Exception\Validation\Base64ValidationException;
use Kernel\Components\Exception\Validation\ValidationException;
use Kernel\Components\File\FileHelper;
use Kernel\Components\File\UploadFile\KernelUploadedFileInterface;
use Kernel\Components\File\UploadFile\PsrUploadedFile;
use Kernel\Components\File\UploadFile\UploadedFileCollection;
use Kernel\Enums\EnumCollection;
use Kernel\ValueObjects\AbstractValueObject;
use Kernel\ValueObjects\ValueObjectCollection;
use LogicException;
use Psr\Http\Message\UploadedFileInterface as PsrUploadedFileInterface;
use ReflectionException;
use RuntimeException;

final readonly class ObjectTypeCast
{
    /**
     * @param mixed $value
     * @param string $type
     * @return object
     * @throws Base64ValidationException
     * @throws FileNotFoundException
     * @throws FilePermissionDeniedException
     * @throws IncorrectFileFormatException
     * @throws NotValidEntityException
     * @throws ReflectionException
     * @throws TypeCastException
     * @throws UndefinedMimeTypeException
     * @throws ValidationException
     */
    public static function convertValueToObject(mixed $value, string $type): ?object
    {
        return match (true) {
            is_subclass_of($type, BackedEnum::class) => self::parseEnum($value, $type),
            is_subclass_of($type, EnumCollection::class) => self::parseEnumCollection($value, $type),
            $type === KernelUploadedFileInterface::class => self::parseUploadedFile($value),
            $type === UploadedFileCollection::class => self::parseUploadedFiles($value),
            $type === DateTime::class => self::parseDateTime($value),
            $type === DateTimeImmutable::class => self::parseDateTimeImmutable($value),
            is_subclass_of($type, AbstractValueObject::class) => self::parseValueObject($value, $type),
            is_subclass_of($type, ValueObjectCollection::class) => self::parseValueObjectCollection($value, $type),
            default => throw new TypeCastException("$type is not supported for type cast!")
        };
    }

    /**
     * @param class-string<BackedEnum> $type
     * @throws TypeCastException
     */
    private static function parseEnum(mixed $value, string $type): ?BackedEnum
    {
        if (is_int($value) || is_string($value)) {
            return $type::tryFrom($value);
        }
        throw new TypeCastException();
    }

    /**
     * @template TEnum of BackedEnum
     * @template TEnumCollection of EnumCollection<TEnum, int|string>
     * @param class-string<TEnumCollection> $type
     * @return TEnumCollection
     * @throws NotValidEntityException
     * @throws TypeCastException
     */
    private static function parseEnumCollection(mixed $value, string $type): EnumCollection
    {
        if (!is_array($value)) {
            throw new TypeCastException();
        }
        /** @var list<value-of<TEnum>> $value */
        return (new $type())->addRawValues($value);
    }

    /**
     * @phan-suppress PhanTypeMismatchReturn
     * @throws FileNotFoundException
     * @throws FilePermissionDeniedException
     * @throws IncorrectFileFormatException
     * @throws Base64ValidationException
     * @throws LogicException
     * @throws ReflectionException
     * @throws RuntimeException
     * @throws TypeCastException
     * @throws UndefinedMimeTypeException
     */
    private static function parseUploadedFile(mixed $value): KernelUploadedFileInterface
    {
        if (!is_string($value) && !$value instanceof PsrUploadedFileInterface) {
            throw new TypeCastException();
        }

        if ($value instanceof PsrUploadedFileInterface) {
            return new PsrUploadedFile($value);
        }
        return (new FileHelper())->getFileObjectFromBase64($value);
    }

    /**
     * @throws TypeCastException
     * @throws Base64ValidationException
     * @throws FileNotFoundException
     * @throws FilePermissionDeniedException
     * @throws IncorrectFileFormatException
     * @throws ReflectionException
     * @throws LogicException
     * @throws RuntimeException
     * @throws UndefinedMimeTypeException
     */
    private static function parseUploadedFiles(mixed $value): UploadedFileCollection
    {
        if (!is_array($value)) {
            throw new TypeCastException();
        }

        /** @var list<string|PsrUploadedFileInterface> $value */
        $collection = new UploadedFileCollection();
        foreach ($value as $item) {
            $collection->add(self::parseUploadedFile($item));
        }
        return $collection;
    }

    /**
     * @throws TypeCastException|Exception
     */
    private static function parseDateTime(mixed $value): DateTime
    {
        self::validateDateString($value);
        /** @var string $value */
        return new DateTime($value);
    }

    /**
     * @throws TypeCastException|Exception
     */
    private static function parseDateTimeImmutable(mixed $value): DateTimeImmutable
    {
        self::validateDateString($value);
        /** @var string $value */
        return new DateTimeImmutable($value);
    }

    /** @throws TypeCastException */
    private static function validateDateString(mixed $value): void
    {
        if (!is_string($value) || !is_int(strtotime($value))) {
            throw new TypeCastException();
        }
    }

    /**
     * @param mixed $value
     * @param class-string<AbstractValueObject> $type
     * @return AbstractValueObject
     */
    private static function parseValueObject(mixed $value, string $type): AbstractValueObject
    {
        return new $type($value);
    }

    /**
     * @param class-string<ValueObjectCollection> $type
     * @throws TypeCastException
     * @throws NotValidEntityException
     * @throws ValidationException
     */
    private static function parseValueObjectCollection(mixed $value, string $type): ValueObjectCollection
    {
        if (!is_array($value)) {
            throw new TypeCastException();
        }
        /** @var list<mixed> $value */
        return (new $type())->addRawValues($value);
    }
}
