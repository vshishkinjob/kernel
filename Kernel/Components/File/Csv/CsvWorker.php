<?php

namespace Kernel\Components\File\Csv;

use InvalidArgumentException;
use Kernel\Components\Config\ConfigFile;
use Kernel\Components\Exception\File\FilePermissionDeniedException;
use Kernel\Components\File\FileSaveInterface;
use Kernel\Components\File\FileWorkerInterface;
use Kernel\Components\File\ReportData;
use Kernel\Components\File\WriteInterface;
use Kernel\Components\Response\ResponseFactory;
use Slim\Psr7\Stream;

//TODO: добавить тесты
readonly class CsvWorker implements FileWorkerInterface
{
    public function __construct(
        private WriteInterface $writer,
        private FileSaveInterface $csv,
        private ConfigFile $configFile
    ) {
    }

    public function create(ReportData $data): string
    {
        $this->writer->write($data);
        $fileLocation = $this->getTempName();
        $this->save($fileLocation);

        return $fileLocation;
    }

    public function read(string $filename): array
    {
        return [];
    }

    /**
     * @throws InvalidArgumentException
     * @throws FilePermissionDeniedException
     */
    public function send(string $fileLocation, string $filename): void
    {
        $this->setHeaders($fileLocation, $filename);
        unlink($fileLocation);
    }

    public function save(string $fileLocation): void
    {
        $this->csv->setWriter($this->writer);
        $this->csv->save($fileLocation);
    }

    /**
     * @return non-empty-string
     */
    private function getTempName(): string
    {
        return $this->configFile->getConfigByKey('runtimeFolder') . '/' . uniqid() . '.csv';
    }

    /**
     * @throws InvalidArgumentException
     * @throws FilePermissionDeniedException
     */
    private function setHeaders(string $fileLocation, string $filename): void
    {
        $response = ResponseFactory::getResponse();
        $encodedFilename = rawurlencode($filename);
        $response = $response->withHeader('Access-Control-Expose-Headers', 'Content-Disposition, Content-Type')
            ->withHeader('Content-Type', 'application/csv; charset=utf-8')
            ->withHeader(
                'Content-Disposition',
                "attachment; filename=\"{$filename}\"; filename*=UTF-8''$encodedFilename"
            );
        $resource = fopen($fileLocation, 'r');
        if (!is_resource($resource)) {
            throw new FilePermissionDeniedException();
        }
        $stream = new Stream($resource);
        ResponseFactory::setResponse($response->withBody($stream));
    }
}
