<?php

declare(strict_types=1);

namespace Kernel\Components\Repository\Components\Tps;

use Exception;
use GuzzleHttp\Exception\ConnectException;
use Kernel\Components\Client\AppClientInterface;
use Kernel\Components\Config\ConfigFile;
use Kernel\Components\Exception\App\GatewayTimeoutException;
use Kernel\Components\Exception\App\TypeCastException;
use Kernel\Components\Exception\TPS\BaseTpsException;
use Kernel\Components\Exception\TPS\TpsExceptionFactory;
use Kernel\Components\Repository\Components\BaseEntity;
use Kernel\Components\Repository\Components\Tps\Annotation\TpsColumn;
use Kernel\Components\Repository\Components\Tps\Annotation\TypeCast;
use ReflectionClass;
use ReflectionException;
use RuntimeException;

/**
 * @template TEntity of BaseEntity
 */
final readonly class TpsRepository
{
    public function __construct(
        private ConfigFile $config,
        private AppClientInterface $client,
        private TpsHeaders $tpsHeaders
    ) {
    }

    /**
     * @return array<array-key, mixed>
     * @throws GatewayTimeoutException
     * @throws BaseTpsException
     * @throws RuntimeException
     * @throws Exception
     */
    public function resolve(TpsInterface $repository): array
    {
        $this->tpsHeaders->setRepositoryHeaders($repository->getRequestHeaders());
        $tpsRequest = new TpsRequest(
            $repository->getCommand(),
            $repository->getRequestBody(),
            $this->tpsHeaders
        );
        return $this->executeQuery($tpsRequest);
    }

	/**
	 * @param TpsRequest $tpsRequest
	 * @return array<array-key, mixed>
	 * @throws GatewayTimeoutException
	 * @throws BaseTpsException
	 * @throws RuntimeException
	 * @throws Exception
	 */
    private function executeQuery(
        TpsRequest $tpsRequest
    ): array {
        $requestBody = $tpsRequest->getOptions();
        /** @var array{host: string} $tpsConfig */
        $tpsConfig = $this->config->getConfigByKey('tps');
        try {
            $response = $this->client->sendRequest(
                'POST',
                $tpsConfig['host'] . $tpsRequest->getUrl(),
                $requestBody
            )->getBody()->getContents();
        } catch (ConnectException $exception) {
            throw new GatewayTimeoutException("Tps unavailable or response takes too long!");
        }
        /**
         * @var array{
         *     errorCode?: string,
         *     responseData?: int|string|bool|array<array-key, mixed>|float
         * } $responseDecoded
         */
        $responseDecoded = json_decode($response, true);

        if (!empty($responseDecoded['errorCode'])) {
            $exception = (new TpsExceptionFactory())->getTpsExceptionByCode((int)$responseDecoded['errorCode']);
            $exception->setLogData(['tpsRequest' => $requestBody + ['url' => $tpsRequest->getUrl()]]);
            throw $exception;
        }
        return (array)($responseDecoded['responseData'] ?? []);
    }

	/**
	 * @param array<array-key, array<array-key, mixed>> $data
	 * @param class-string<TEntity> $class
	 * @return list<TEntity>
	 * @throws ReflectionException
	 * @throws Exception|TypeCastException
	 */
    public function convertToObject(array $data, string $class): array
    {
        $entities = [];

        foreach ($data as $entityValues) {
            $entities[] = $this->getEntity($entityValues, $class);
        }

        return $entities;
    }


    /**
     * @param array<array-key, mixed> $data
     * @param class-string<TEntity> $class
     * @return TEntity
     * @throws ReflectionException
     * @throws Exception|TypeCastException
     */
    private function getEntity(array $data, string $class): BaseEntity
    {
        $reflection = new ReflectionClass($class);
        $entity = $reflection->newInstanceWithoutConstructor();
        $properties = $reflection->getProperties();

        foreach ($properties as $property) {
            $attribute = $property->getAttributes(TpsColumn::class);
            $column = null;

            if ($attribute) {
                /** @var array{name: string|list<string>, type: non-empty-string|null} $arguments */
                $arguments = $attribute[0]->getArguments();
                $column = $this->getColumnName($arguments['name'], $data);
                if (isset($arguments['type'])) {
                    /**
                     * @var array<array-key,mixed>|bool|float|int|string|null $value
                     */
                    $value = $data[$column] ?? null;
                    $data[$column] = TypeCast::cast($value, $arguments['type']);
                }
            }

            $field = $column ?? $property->name;

            $property->setValue($entity, $data[$field] ?? null);
        }

        return $entity;
    }

    /**
     * @param string|list<string> $name
     * @param array<array-key, mixed> $data
     */
    private function getColumnName(string|array $name, array $data): string
    {
        if (is_string($name)) {
            return $name;
        }
        foreach ($name as $column) {
            if (array_key_exists($column, $data)) {
                return $column;
            }
        }
        return $name[0];
    }
}
