<?php

namespace Kernel\Repositories\Tps;

use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Kernel\Components\Exception\App\GatewayTimeoutException;
use Kernel\Components\Exception\App\TypeCastException;
use Kernel\Components\Exception\TPS\BaseTpsException;
use Kernel\Components\Repository\Components\Tps\Commands\Commands;
use Kernel\Components\Repository\Components\Tps\TpsInterface;
use Kernel\Components\Repository\Components\Tps\TpsRepository;
use Kernel\Entities\User\Tps\SubjectData;
use Kernel\Repositories\Interfaces\IdentityInterface;
use Kernel\ValueObjects\Token;
use ReflectionException;
use RuntimeException;

class GetCurrentSubjectDataRepository implements IdentityInterface, TpsInterface
{
    private ?Token $token;
    private SubjectData $subjectData;

    /** @param TpsRepository<SubjectData> $repository */
    public function __construct(
        private readonly TpsRepository $repository
    ) {
    }

    public function getCommand(): Commands
    {
        return Commands::GET_CURRENT_SUBJECT_DATA;
    }

    public function setSubjectData(SubjectData $subjectData): void
    {
        $this->subjectData = $subjectData;
    }

	/**
	 * @throws GuzzleException|ReflectionException|GatewayTimeoutException
	 * @throws BaseTpsException|RuntimeException|Exception|TypeCastException
	 */
    public function getUserIdentity(?Token $token = null): SubjectData
    {
        if (isset($this->subjectData)) {
            return $this->subjectData;
        }

        $this->token = $token;
        $subjectData = $this->repository->resolve($this);
        $subjectData = $this->repository->convertToObject(
            [$subjectData],
            $this->getEntityClassName()
        )[0];

        $this->setSubjectData($subjectData);
        return $subjectData;
    }

    public function getRequestBody(): array
    {
        return [];
    }

    /** @return class-string<SubjectData> */
    private function getEntityClassName(): string
    {
        return SubjectData::class;
    }

    public function getRequestHeaders(): array
    {
        if (isset($this->token)) {
            return ['auth-token' => $this->token->getValue() ?? ''];
        }
        return [];
    }
}
