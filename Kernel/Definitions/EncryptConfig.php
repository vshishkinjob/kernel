<?php

namespace Kernel\Definitions;

final class EncryptConfig
{
	public function __construct(
		private string $salt,
		private string $iv,
		private string $key
	) {
	}

	public function getSalt(): string
	{
		return $this->salt;
	}

	public function getIv(): string
	{
		return $this->iv;
	}

	public function getKey(): string
	{
		return $this->key;
	}
}
