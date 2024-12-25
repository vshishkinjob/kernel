<?php

declare(strict_types=1);

namespace Kernel\Components\Static;

use Exception;
use JsonSerializable;
use Kernel\Components\Exception\File\FileNotFoundException;
use Kernel\Components\Exception\Validation\ValidationException;
use Kernel\Components\Response\HttpResponseCode;
use Kernel\ValueObjects\Url;
use Stringable;

final readonly class StaticFile implements JsonSerializable, Stringable
{
    private Url $url;

    /**
     * @throws ValidationException
     */
    public function __construct(
        private string $staticPath,
        private string $staticUrl,
        private string $staticDir,
        private string $staticFileName,
        private ?string $localFileName = null,
        private ?string $localPathName = null
    ) {
        $this->url = new Url($this->staticUrl . $this->staticDir . $this->staticFileName);
    }

	/**
	 * @param string $name
	 * @return string
	 * @throws Exception
	 */
    public static function createFileStaticName(string $name): string
    {
        return md5(time() . random_int(0, 1000)) . substr($name, -4);
    }

	/**
	 * @throws FileNotFoundException
	 */
    public function getLocalFullFilePath(): string
    {
        if (!isset($this->localPathName)) {
            throw new FileNotFoundException("Файл не существует локально!");
        }
        return $this->localPathName;
    }

	/**
	 * @throws FileNotFoundException
	 */
    public function getLocalFileName(): string
    {
        if (!isset($this->localFileName)) {
            throw new FileNotFoundException("Файл не существует локально!");
        }
        return $this->localFileName;
    }

    public function getStaticFileName(): string
    {
        return $this->staticFileName;
    }

    public function getStaticFullUrl(): Url
    {
        return $this->url;
    }

    public function getStaticDirectoryPath(): string
    {
        return $this->staticPath . $this->staticDir;
    }

    public function getStaticFullPath(): string
    {
        return $this->staticPath . $this->staticDir . $this->staticFileName;
    }

	/**
	 * @throws ValidationException
	 */
    public static function createFromUrl(
        Url $fullUrl,
        string $staticPath,
        string $staticUrl
    ): self {
        if (!str_contains($fullUrl->url, $staticUrl)) {
            throw new ValidationException(
                "Ссылка на файл не содержит url статик сервера!",
                HttpResponseCode::InternalServerError->value
            );
        }

        $path = self::parsePath($fullUrl->url);
        if ($path === null || $path === '/') {
            throw new ValidationException(
                "Не удалось преобразовать url в путь к файлу!",
                HttpResponseCode::InternalServerError->value
            );
        }
        $path = trim($path, '/');

        return new self(
            $staticPath,
            $staticUrl,
            self::getDirectoryFromPath($path),
            self::getFileStaticNameFromPath($path)
        );
    }

    private static function parsePath(string $fileUrl): ?string
    {
        return parse_url($fileUrl)['path'] ?? null;
    }


    private static function getDirectoryFromPath(string $path): string
    {
        $array = explode('/', $path);
        if (count($array) === 1) {
            return '';
        }
        array_pop($array);
        return implode('/', $array) . '/';
    }


    private static function getFileStaticNameFromPath(string $path): string
    {
        $array = explode('/', $path);
        return array_pop($array);
    }

    public function jsonSerialize(): string
    {
        return $this->getStaticFullUrl()->url;
    }

    public function __toString(): string
    {
        return $this->getStaticFullUrl()->url;
    }
}
