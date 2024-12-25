<?php

namespace Kernel\ValueObjects;

use Kernel\Components\Exception\Validation\ValidationException;

/**
 * Mutable since created in container from start, but modified in SessionMiddleware
 */
final class Token
{
    private ?string $token;

    /**
     * @throws ValidationException
     */
    public function __construct(mixed $value = null)
    {
        $this->validate($value);
        /** @var string|null $value */
        $this->token = $value;
    }

    public function getValue(): ?string
    {
        return $this->token;
    }

    /**
     * @throws ValidationException
     */
    protected function validate(mixed $value): void
    {
        if ($value !== null && !is_string($value)) {
            throw new ValidationException("Token must be string or null!");
        }
    }

    public function setToken(?string $token): void
    {
        $this->token = $token;
    }
}
