<?php

declare(strict_types=1);

namespace Kernel\Components\Helpers;

use Exception;
use Kernel\ValueObjects\Password;

final readonly class PasswordGenerator
{
    public function __construct(
        private string $letters = 'abcdefghijklmnopqrstuvwxyz',
        private string $digits = '0123456789',
        private string $specialChars = '()@#.,:;?!*+%@[]_{}$#',
        private int $maxSimilarity = 20
    ) {
    }

    /**
     * @param list<string> $diffStrings
     * @throws Exception
     */
    public function generate(
        ?int $minLength = null,
        int $maxLength = 16,
        ?int $exactly = null,
        array $diffStrings = [],
        bool $shouldHaveUpperCase = true,
        bool $shouldHaveSpecialChar = true,
        bool $shouldHaveDigit = true
    ): Password {
        // List of usable characters
        $chars = $this->letters . mb_strtoupper($this->letters) . $this->digits . $this->specialChars;

        // Set to true when a valid password is generated
        $passwordReady = false;
        $password = '';

        while (!$passwordReady) {
            // The password
            $password = '';

            // Password requirements
            $hasLowercase = false;
            $hasUppercase = false;
            $hasDigit = false;
            $hasSpecialChar = false;

            // A random password length
            $length = $this->getLength($maxLength, $minLength, $exactly);

            while ($length > 0) {
                $length--;

                // Choose a random character and add it to the password
                $index = random_int(0, mb_strlen($chars) - 1);
                $char = $chars[$index];
                $password .= $char;

                // Verify the requirements
                $hasLowercase = $hasLowercase || (mb_strpos($this->letters, $char) !== false);
                $hasUppercase = !$shouldHaveUpperCase
                    || $hasUppercase
                    || (mb_strpos(mb_strtoupper($this->letters), $char) !== false);
                $hasDigit = !$shouldHaveDigit
                    || $hasDigit
                    || (mb_strpos($this->digits, $char) !== false);
                $hasSpecialChar = !$shouldHaveSpecialChar
                    || $hasSpecialChar
                    || (mb_strpos($this->specialChars, $char) !== false);
            }

            $passwordReady = ($hasLowercase && $hasUppercase && $hasDigit && $hasSpecialChar);

            // If the new password is valid, check for similarity
            if ($passwordReady) {
                foreach ($diffStrings as $string) {
                    similar_text($password, $string, $similarityPerc);
                    $passwordReady = $passwordReady && ($similarityPerc < $this->maxSimilarity);
                }
            }
        }

        return new Password($password);
    }

    /**
     * @throws Exception
     */
    private function getLength(int $maxLength, ?int $minLength, ?int $exactly): int
    {
        if ($exactly !== null) {
            return $exactly;
        }

        $minLength = empty($minLength) ? 1 : $minLength;
        return random_int($minLength, $maxLength);
    }
}
