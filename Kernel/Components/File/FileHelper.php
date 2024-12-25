<?php

declare(strict_types=1);

namespace Kernel\Components\File;

use DomainException;
use Kernel\Components\Exception\File\FileNotFoundException;
use Kernel\Components\Exception\File\FilePermissionDeniedException;
use Kernel\Components\Exception\File\IncorrectFileFormatException;
use Kernel\Components\Exception\File\UndefinedMimeTypeException;
use Kernel\Components\Exception\Validation\Base64ValidationException;
use Kernel\Components\File\UploadFile\SplUploadedFile;
use Kernel\Components\Validation\rules\Base64;
use LogicException;
use ReflectionException;
use RuntimeException;
use Yiisoft\Validator\Validator;

class FileHelper
{
    private const MIMES = [
        'jpg' => [
            'image/jpeg',
            'image/jpm',
            'image/jpx'
        ],
        'png' => ['image/png'],
        'svg' => ['image/svg+xml'],
        'mp4' => ['video/mp4', 'video/mp4v-es'],
        'doc' => [
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
        ],
        'xls' => [
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        ],
        'zip' => ['application/zip', 'application/zlib'],
        'pdf' => ['application/pdf'],
        'txt' => ['text/plain'],
        'ods' => [
            'application/vnd.oasis.opendocument.spreadsheet',
            'application/vnd.oasis.opendocument.text',
            'application/vnd.oasis.opendocument.presentation'
        ]
    ];

    private const EXTENSIONS = [
        'jpg' => [
            'jpeg',
            'jpg',
            'jpe'
        ],
        'png' => [
            'png'
        ],
        'mp4' => [
            'mp4',
            'mp4v',
            'mpg4',
        ],
        'doc' => [
            'doc',
            'dot',
            'docx'
        ],
        'xls' => [
            'xls',
            'xlm',
            'xla',
            'xlc',
            'xlt',
            'xlw',
            'xlsx'
        ],
        'zip' => ['zip'],
        'pdf' => ['pdf'],
        'txt' => ['txt'],
        'ods' => ['ods'],
    ];


    /**
     * @throws Base64ValidationException
     * @throws FileNotFoundException
     * @throws FilePermissionDeniedException
     * @throws IncorrectFileFormatException
     * @throws ReflectionException
     * @throws LogicException
     * @throws RuntimeException
     * @throws UndefinedMimeTypeException
     */
    public function getFileObjectFromBase64(string $base64, string $mode = 'r'): SplUploadedFile
    {
        if (!$this->isBase64($base64)) {
            throw new Base64ValidationException();
        }
        $base64Decoded = base64_decode($base64);

        $temp = tmpfile();
        if (!is_resource($temp) || !is_string($base64Decoded)) {
            throw new FilePermissionDeniedException(message: 'Не удалось создать временный файл');
        }

        fwrite($temp, $base64Decoded);
        $path = stream_get_meta_data($temp)['uri'];
        $ext = $this->getExtensionFromPath($path);

        return $this->copyFile(
            from: $path,
            to: $path . '.' . $ext,
            mode: $mode
        );
    }

    /**
     * @throws IncorrectFileFormatException
     * @throws UndefinedMimeTypeException
     */
    public function getExtensionFromPath(string $filePath, bool $checkForFileNameExtension = false): string
    {
        $mime = mime_content_type($filePath);
        if (!is_string($mime)) {
            throw new UndefinedMimeTypeException();
        }
        $extFromMime = $this->extensionArraySearch($mime, self::MIMES)
            ?? throw new IncorrectFileFormatException();

        if ($checkForFileNameExtension === false) {
            return $extFromMime;
        }

        $extFromPath = $this->getExtensionFromFileName($filePath);
        if ($extFromMime !== $extFromPath) {
            throw new IncorrectFileFormatException();
        }
        return $extFromMime;
    }

    /**
     * @throws FileNotFoundException
     * @throws FilePermissionDeniedException
     * @throws LogicException
     * @throws RuntimeException
     */
    public function copyFile(
        string $from,
        string $to,
        string $mode = 'r'
    ): SplUploadedFile {
        if (!file_exists($from)) {
            throw new FileNotFoundException("File $from do not exists");
        }

        if (!copy($from, $to)) {
            throw new FilePermissionDeniedException("Unable to copy file from: $from to: $to");
        }

        return new SplUploadedFile($to, $mode);
    }

    /**
     * @throws IncorrectFileFormatException
     */
    private function getExtensionFromFileName(string $filename): string
    {
        $dotPosition = strrpos($filename, ".");
        if ($dotPosition === false) {
            throw new IncorrectFileFormatException();
        }
        $fileExtension = substr($filename, $dotPosition + 1);
        return $this->extensionArraySearch($fileExtension, self::EXTENSIONS)
            ?? throw new IncorrectFileFormatException();
    }

    /**
     * @param array<string, list<string>> $haystack
     */
    private function extensionArraySearch(string $needle, array $haystack): ?string
    {
        foreach ($haystack as $ext => $items) {
            if (in_array($needle, $items, strict: true)) {
                return $ext;
            }
        }
        return null;
    }

    /**
     * @throws ReflectionException
     */
    private function isBase64(?string $base64): bool
    {
        $validation = (new Validator())->validate($base64, new Base64());

        return empty($validation->getErrors());
    }
}
