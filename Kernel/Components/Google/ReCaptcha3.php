<?php

declare(strict_types=1);

namespace Kernel\Components\Google;

use Kernel\Components\Config\ConfigFile;
use ReCaptcha\ReCaptcha;
use RuntimeException;

final readonly class ReCaptcha3
{
    private string $secretKey;

    public function __construct(ConfigFile $config)
    {
        /** @var array{secretKey: string} $reCaptcha */
        $reCaptcha = $config->getConfigByKey('reCaptcha3');
        $this->secretKey = $reCaptcha['secretKey'];
    }

	/**
	 * @throws RuntimeException
	 */
    public function isValid(string $captchaResponse): bool
    {
        $response = $this->createCaptcha()->verify($captchaResponse, $_SERVER['HTTP_USER_AGENT'] ?? '');
        return $response->isSuccess();
    }

	/**
	 * @throws RuntimeException
	 */
    protected function createCaptcha(): ReCaptcha
    {
        return new ReCaptcha($this->secretKey);
    }
}
