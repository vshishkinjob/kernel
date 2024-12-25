<?php

declare(strict_types=1);

namespace Kernel\Components\Method;

use Kernel\Components\Exception\App\InvalidReflectionTypeException;
use Kernel\Components\Exception\App\NotValidEntityException;
use Kernel\Components\Exception\App\TypeCastException;
use Kernel\Components\Exception\File\FileNotFoundException;
use Kernel\Components\Exception\File\FilePermissionDeniedException;
use Kernel\Components\Exception\File\IncorrectFileFormatException;
use Kernel\Components\Exception\File\UndefinedMimeTypeException;
use Kernel\Components\Exception\Http\BadRequestException;
use Kernel\Components\Exception\Validation\Base64ValidationException;
use Kernel\Components\Exception\Validation\ValidationException;
use Kernel\Components\Helpers\ObjectTypeCast;
use Kernel\Components\Request\RoutineInterface;
use LogicException;
use ReflectionException;
use ReflectionNamedType;
use ReflectionProperty;
use RuntimeException;
use Yiisoft\Validator\Result;
use Yiisoft\Validator\RuleInterface;
use Yiisoft\Validator\ValidationContext;
use Yiisoft\Validator\Validator;

abstract class AbstractDTO
{
	/** @var array<string, mixed> $arrayData */
	private array $arrayData = [];
	private Validator $validator;
    private ?ValidationContext $context = null;

    /**
     * @param RoutineInterface $data
     * @return AbstractDTO
     * @throws BadRequestException
     * @throws Base64ValidationException
     * @throws FileNotFoundException
     * @throws FilePermissionDeniedException
     * @throws IncorrectFileFormatException
     * @throws InvalidReflectionTypeException
     * @throws NotValidEntityException
     * @throws ReflectionException
     * @throws TypeCastException
     * @throws ValidationException
     * @throws UndefinedMimeTypeException
     */
	public function parseRequestToDto(RoutineInterface $data): AbstractDTO
	{
		$this->arrayData = $data->getMethodParams();
		if (!empty($data->getProtocol()->getUploadedFiles())) {
			foreach ($data->getProtocol()->getUploadedFiles() as $key => $file) {
				$this->setDataByKey($key, $file);
			}
		}
		$this->validate();

		return $this;
	}

	/**
	 * @return array<array-key, RuleInterface|list<RuleInterface>>
	 */
	abstract protected function rules(): array;

	public function setValidator(Validator $validator, ?ValidationContext $context = null): void
	{
		$this->validator = $validator;
        $this->context = $context;
	}

    /**
     * @throws Base64ValidationException|FileNotFoundException|FilePermissionDeniedException
     * @throws ReflectionException|LogicException|RuntimeException|TypeCastException
     * @throws NotValidEntityException|InvalidReflectionTypeException|IncorrectFileFormatException
     * @throws ValidationException|BadRequestException
     * @throws UndefinedMimeTypeException
     */
    public function validate(): void
    {
        $properties = array_keys($this->arrayData);
        foreach ($properties as $property) {
            if (!is_string($property) || !property_exists($this, $property)) {
                throw new BadRequestException("Bad request. Field: $property do not exists");
            }
        }

		$result = $this->validator->validate($this->arrayData, $this->rules(), $this->context);

		if (!empty($result->getErrors())) {
			throw new ValidationException(additionalData: $this->prepareValidateErrorOptions($result));
		}

		$this->parseValidatedData();
	}

	/**
	 * @return list<array{message:string, attribute: string}>
	 */
	private function prepareValidateErrorOptions(Result $result): array
	{
		$data = [];
		foreach ($result->getErrors() as $error) {
			$data[] = [
				'message' => $error->getMessage(),
				'attribute' => (string) ($error->getParameters()['attribute'] ?? 'unknown')
			];
		}
		return $data;
	}

	/**
	 * @param list<string>|null $except
	 * @param list<string>|null $only
	 * @return array<string, mixed>
	 */
	public function getArrayData(?array $except = null, ?array $only = null): array
	{
		if ($except === null && $only === null) {
			return $this->arrayData;
		}
		$array = [];
		foreach ($this->arrayData as $key => $data) {
			if (
				($except === null || !in_array($key, $except, true))
				&& ($only === null || in_array($key, $only, true))
			) {
				$array[$key] = $data;
			}
		}
		return $array;
	}

	/**
	 * @param array<string, mixed> $arrayData
	 */
	public function setArrayData(array $arrayData): void
	{
		$this->arrayData = $arrayData;
	}

	public function setDataByKey(string $key, mixed $data): void
	{
		$this->arrayData[$key] = $data;
	}

    /**
     * @throws Base64ValidationException|FileNotFoundException|FilePermissionDeniedException
     * @throws ReflectionException|LogicException|RuntimeException|TypeCastException
     * @throws NotValidEntityException|InvalidReflectionTypeException|IncorrectFileFormatException
     * @throws ValidationException
     * @throws UndefinedMimeTypeException
     */
	private function parseValidatedData(): void
	{
		foreach ($this->arrayData as $param => $value) {
			$this->$param = $this->parseValue($param, $value);
		}
	}

    /**
     * @param string $param
     * @param mixed $value
     * @return mixed
     * @throws Base64ValidationException|FileNotFoundException|FilePermissionDeniedException
     * @throws ReflectionException|LogicException|RuntimeException|TypeCastException
     * @throws NotValidEntityException|InvalidReflectionTypeException|IncorrectFileFormatException
     * @throws ValidationException
     * @throws UndefinedMimeTypeException
     */
	private function parseValue(string $param, mixed $value): mixed
	{
		if ($value === null) {
			return null;
		}

		$property = new ReflectionProperty($this, $param);

		$type = $property->getType();
		if (!$type instanceof ReflectionNamedType) {
            throw new InvalidReflectionTypeException('Property parsing only allowed with ReflectionNamedType');
		}

        $type = $type->getName();
        if (class_exists($type) || interface_exists($type)) {
            return ObjectTypeCast::convertValueToObject($value, $type);
        } elseif ($type === 'string' && is_string($value)) {
            return htmlspecialchars($value);
        } elseif ($type === 'array' && is_array($value)) {
            return $this->shieldXSS($value);
        } elseif ($type === 'int' && is_numeric($value)) {
            // Все данные в $_POST хранятся в виде строки.
            // Корректность типов нужно контролировать на уровне правил валидации!
            return (int)$value;
        } elseif ($type === 'float' && is_numeric($value)) {
            return (float)$value;
        } elseif ($type === 'bool' && is_bool($value)) {
            return $value;
        }

        throw new NotValidEntityException("Failed to parse value to DTO property");
	}


	/**
	 * @param array<array-key, mixed> $value
	 * @return array<array-key, mixed>
	 */
	private function shieldXSS(array $value): array
	{
		foreach ($value as $key => $item) {
			if (is_array($item)) {
				$value[$key] = $this->shieldXSS($item);
			} elseif (is_string($item)) {
				$value[$key] = htmlspecialchars($item);
			}
		}
		return $value;
	}
}
