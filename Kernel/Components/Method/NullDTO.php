<?php

declare(strict_types=1);

namespace Kernel\Components\Method;

class NullDTO extends AbstractDTO
{
	protected function rules(): array
	{
		return [];
	}
}
