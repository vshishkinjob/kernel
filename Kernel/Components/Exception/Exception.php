<?php

declare(strict_types=1);

namespace Kernel\Components\Exception;

use Kernel\Components\Response\HttpResponseCode;
use Throwable;

abstract class Exception extends \Exception implements HttpCodeExceptionInterface, ErrorLevelInterface
{
    /** @var array<string, mixed> $logData */
    private array $logData = [];

    /**
     * @phan-suppress PhanTypeMismatchArgumentNullableInternal
     * @param mixed[] $additionalData
     */
    public function __construct(
        string $message,
        int $code,
        ?Throwable $previous,
        protected array $additionalData
    ) {
        parent::__construct($message, $code, $previous);
    }

    public function getHttpStatusCode(): int
    {
        return $this->getCode();
    }

    /** @return mixed[] */
    public function getAdditionalData(): array
    {
        return $this->additionalData;
    }


    /** @return  array<string, mixed> */
    public function getLogData(): array
    {
        return $this->logData;
    }


    /** @param  array<string, mixed> $logData */
    public function setLogData(array $logData): void
    {
        $this->logData = $logData;
    }
}
