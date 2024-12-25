<?php

namespace Kernel\Components\Repository\Components\DB\Orm;

use Cycle\Annotated\Embeddings;
use Cycle\Annotated\Entities;
use Cycle\Annotated\MergeColumns;
use Cycle\Annotated\MergeIndexes;
use Cycle\Annotated\TableInheritance;
use Cycle\Database\Config\DatabaseConfig;
use Cycle\Database\Config\Postgres\TcpConnectionConfig;
use Cycle\Database\Config\PostgresDriverConfig;
use Cycle\Database\DatabaseInterface;
use Cycle\Database\DatabaseManager;
use Cycle\ORM\EntityManager;
use Cycle\ORM\Factory;
use Cycle\ORM\ORM;
use Cycle\ORM\Parser\Typecast;
use Cycle\ORM\Schema;
use Cycle\ORM\SchemaInterface;
use Cycle\Schema\Compiler;
use Cycle\Schema\Defaults;
use Cycle\Schema\Generator\GenerateModifiers;
use Cycle\Schema\Generator\GenerateRelations;
use Cycle\Schema\Generator\GenerateTypecast;
use Cycle\Schema\Generator\RenderModifiers;
use Cycle\Schema\Generator\RenderRelations;
use Cycle\Schema\Generator\RenderTables;
use Cycle\Schema\Generator\ResetTables;
use Cycle\Schema\Generator\ValidateEntities;
use Cycle\Schema\Registry;
use Error;
use Kernel\Components\Config\ConfigFile;
use Kernel\Components\Exception\DB\BaseDbException;
use Kernel\Components\Exception\DB\DbExceptionResolver;
use Kernel\Components\Exception\DB\EntityNotFoundException;
use Kernel\Components\Logger\KernelLoggerInterface;
use Kernel\Components\Repository\Components\DB\AbstractDbRepository;
use Kernel\Components\Repository\Components\DB\DbEntity;
use Kernel\Components\Repository\Components\DB\DbInterface;
use Kernel\Components\Repository\Components\DB\Interfaces\Repository\RepositoryInterface;
use Kernel\Components\Repository\Components\DB\TypeCast\ArrayTypeCast;
use Kernel\Components\Repository\Components\DB\TypeCast\EmailTypeCast;
use Kernel\Components\Repository\Components\DB\TypeCast\JsonTypeCast;
use Kernel\Components\Repository\Components\DB\TypeCast\UrlTypeCast;
use Kernel\Definitions\interfaces\DbConfigInterface;
use Psr\SimpleCache\CacheInterface;
use Psr\SimpleCache\InvalidArgumentException;
use Spiral\Tokenizer\ClassLocator;
use Symfony\Component\Finder\Exception\DirectoryNotFoundException;
use Symfony\Component\Finder\Finder;
use Throwable;

/**
 * @template TEntity of DbEntity
 * @extends AbstractDbRepository<TEntity>
 */
class Cycle extends AbstractDbRepository
{
    private const CYCLE_SCHEMA_CACHE_KEY = 'cycle.schema';

    protected readonly DatabaseManager $dbal;
    private readonly ORM $orm;
    private readonly EntityManager $entityManager;

    /**
     * @throws BaseDbException
     */
    public function __construct(
        DbConfigInterface $dbConfig,
        KernelLoggerInterface $logger,
        private readonly ConfigFile $configFile,
        private readonly CacheInterface $cache
    ) {
        try {
            parent::__construct($dbConfig, $logger);
            $this->dbal = $this->setDbal();
            $this->orm = $this->initOrm();
            $this->entityManager = $this->getEntityManager();
            RelationMapMock::getInstance($this->orm);
        } catch (Throwable $exception) {
            DbExceptionResolver::resolveDbException($exception, $this->logger);
        }
    }

    private function setDbal(): DatabaseManager
    {
        return new DatabaseManager(
            new DatabaseConfig([
                'default' => $this->dbConfig->getDbName(),
                'databases' => [
                    $this->dbConfig->getDbName() => ['connection' => 'postgres']
                ],
                'connections' => [
                    'postgres' => new PostgresDriverConfig(
                        connection: new TcpConnectionConfig(
                            database: $this->dbConfig->getDbName(),
                            host: $this->dbConfig->getHost(),
                            port: $this->dbConfig->getPort(),
                            user: $this->dbConfig->getUser(),
                            password: $this->dbConfig->getPassword(),
                        ),
                        schema: $this->dbConfig->getSchema(),
                        queryCache: true,
                    ),
                ]
            ])
        );
    }

    /**
     * @infection-ignore-all
     * @throws DirectoryNotFoundException
     * @throws InvalidArgumentException
     */
    private function initOrm(): ORM
    {
        if ($this->cache->has(self::CYCLE_SCHEMA_CACHE_KEY)) {
            /** @var array<non-empty-string, array<int, mixed>> $schema */
            $schema = $this->cache->get(self::CYCLE_SCHEMA_CACHE_KEY);
        } else {
            $schema = $this->buildSchema();
            $this->cache->set(self::CYCLE_SCHEMA_CACHE_KEY, $schema);
        }

        return new ORM(new Factory($this->dbal), new Schema($schema));
    }

    /**
     * @psalm-suppress MixedReturnTypeCoercion
     * @return array<non-empty-string, array<int, mixed>>
     * @throws DirectoryNotFoundException
     */
    private function buildSchema(): array
    {
        /** @var string $entitiesFolder */
        $entitiesFolder = $this->configFile->getConfigByKey('dbEntitiesFolder');
        $finder = (new Finder())->files()->in([
            $entitiesFolder,
            __DIR__ . '/../MockEntity'
        ]); // __DIR__ here is folder with entities
        $classLocator = new ClassLocator($finder);

        return (new Compiler())->compile(
            new Registry(
                $this->dbal,
                new Defaults(defaults: [
                    SchemaInterface::TYPECAST_HANDLER => [
                        Typecast::class,
                        EmailTypeCast::class,
                        UrlTypeCast::class,
                        JsonTypeCast::class,
                        ArrayTypeCast::class
                    ]
                ])
            ),
            [
                new ResetTables(),
                new Embeddings($classLocator),
                new Entities($classLocator),
                new TableInheritance(),
                new MergeColumns(),
                new GenerateRelations(),
                new GenerateModifiers(),
                new ValidateEntities(),
                new RenderTables(),
                new RenderRelations(),
                new RenderModifiers(),
                new MergeIndexes(),
                new GenerateTypecast(),
            ]
        );
    }

    private function getEntityManager(): EntityManager
    {
        return (new EntityManager($this->orm));
    }


    /**
     * @throws BaseDbException
     */
    public function create(DbEntity $entity): DbEntity
    {
        try {
            $this->entityManager->persist($entity)->run();
        } catch (Throwable $exception) {
            DbExceptionResolver::resolveDbException($exception, $this->logger);
        }
        return $entity;
    }

    /**
     * @throws BaseDbException
     * @throws Throwable
     */
    public function delete(DbEntity $entity, bool $cascade = true): void
    {
        try {
            $this->entityManager->delete($entity, $cascade)->run();
        } catch (Error $exception) {
            DbExceptionResolver::resolveDbException($exception, $this->logger);
        }
    }

    public function findAll(DbInterface $repository, array $filters = [], array $orderBy = []): array
    {
        try {
            /**
             * @psalm-suppress TooManyArguments
             * @var array<int, TEntity> $entities
             */
            $entities = $this->orm->getRepository($repository->getEntityClassName())->findAll($filters, $orderBy);
        } catch (Error $exception) {
            DbExceptionResolver::resolveDbException($exception, $this->logger);
        }
        if (empty($entities)) {
            throw new EntityNotFoundException(
                message: 'Entity "' . basename(
                    str_replace(
                        '\\',
                        '/',
                        $repository->getEntityClassName()
                    )
                ) . ' with provided filters not found!',
            );
        }
        return $entities;
    }

    public function findByPk(DbInterface $repository, int $id): DbEntity
    {
        try {
            /**
             * @var TEntity $entity
             */
            $entity = $this->orm->getRepository($repository->getEntityClassName())->findByPK($id);
        } catch (Error $exception) {
            DbExceptionResolver::resolveDbException($exception, $this->logger);
        }
        if ($entity === null) {
            throw new EntityNotFoundException(
                message: 'Entity "' . basename(
                    str_replace(
                        '\\',
                        '/',
                        $repository->getEntityClassName()
                    )
                ) . ' with provided filters not found!',
            );
        }
        return $entity;
    }

    public function findOne(DbInterface $repository, array $filters = []): DbEntity
    {
        try {
            /**
             * @var TEntity $entity
             */
            $entity = $this->orm->getRepository($repository->getEntityClassName())->findOne($filters);
        } catch (Error $exception) {
            DbExceptionResolver::resolveDbException($exception, $this->logger);
        }
        if ($entity === null) {
            throw new EntityNotFoundException(
                message: 'Entity "' . basename(
                    str_replace(
                        '\\',
                        '/',
                        $repository->getEntityClassName()
                    )
                ) . ' with provided filters not found!',
            );
        }
        return $entity;
    }

    /**
     * @throws BaseDbException
     * @throws Throwable
     */
    public function update(DbEntity $entity): void
    {
        try {
            $this->entityManager->persist($entity)->run();
        } catch (Error $exception) {
            DbExceptionResolver::resolveDbException($exception, $this->logger);
        }
    }

    public function repository(DbInterface $repository): RepositoryInterface
    {
        /** @var Repository<TEntity> $repository */
        $repository = new Repository($this->orm, $repository, $this->logger);
        return $repository;
    }

    /**
     * @return DatabaseManager
     */
    public function getDbal(): DatabaseManager
    {
        return $this->dbal;
    }

    /**
     * @suppress PhanPluginAlwaysReturnMethod
     * @throws BaseDbException
     */
    public function getDb(?string $dbName = null): DatabaseInterface
    {
        try {
            $dbName ??= $this->dbConfig->getDbName();
            return $this->dbal->database($dbName);
        } catch (Throwable $exception) {
            DbExceptionResolver::resolveDbException($exception, $this->logger);
        }
    }
}
