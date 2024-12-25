<?php

namespace Kernel\Components\File\Excel\SpreadSheet;

use InvalidArgumentException;
use Kernel\Components\Config\ConfigFile;
use Kernel\Components\File\FileSaveInterface;
use Kernel\Components\File\FileWorkerInterface;
use Kernel\Components\File\ReportData;
use Kernel\Components\File\WriteInterface;
use Kernel\Components\Response\ResponseFactory;
use Slim\Psr7\Stream;

//TODO: добавить тесты
readonly class ExcelWorker implements FileWorkerInterface
{
    public function __construct(
        private WriteInterface $writer,
        private FileSaveInterface $xls,
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
     */
    public function send(string $fileLocation, string $filename): void
    {
        $this->setHeaders($fileLocation, $filename);
        unlink($fileLocation);
    }

    public function save(string $fileLocation): void
    {
        $this->xls->setWriter($this->writer);
        $this->xls->save($fileLocation);
    }

    /**
     * @return non-empty-string
     */
    private function getTempName(): string
    {
        return $this->configFile->getConfigByKey('runtimeFolder') . '/' . uniqid() . '.xls';
    }

    /**
     * @throws InvalidArgumentException
     */
    private function setHeaders(string $fileLocation, string $filename): void
    {
        $response = ResponseFactory::getResponse();
        $encodedFilename = rawurlencode($filename);
        $response = $response->withHeader('Access-Control-Expose-Headers', 'Content-Disposition, Content-Type')
            ->withHeader('Content-Type', 'application/vnd.ms-excel; charset=utf-8')
            ->withHeader(
                'Content-Disposition',
                "attachment; filename=\"{$filename}\"; filename*=UTF-8''$encodedFilename"
            );
        $resource = fopen($fileLocation, 'r');
        if ($resource !== false) {
            $stream = new Stream($resource);
            ResponseFactory::setResponse($response->withBody($stream));
        }
    }
}
