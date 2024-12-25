<?php

declare(strict_types=1);

namespace Kernel\Components\File\Excel\ExcelBook\config;

use Kernel\Components\Config\ConfigFile;

final class ExcelConfigurator
{
    public function __construct(private readonly ConfigFile $config)
    {
        $this->tempFilePath = $this->config->getConfigByKey('runtimeFolder') . '/temp.xls';
    }

    public string $locale = 'UTF-8';
    /** @var non-empty-string $pattern */
	public string $pattern = '/%([^%]+)%/';
	public string $tablePattern = '%table%';
	public int $baseRowHeight = 30;
    public string $tempFilePath;
}
