<?php

declare(strict_types=1);

namespace Kernel\Components\Session;

use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use Kernel\Components\Exception\Session\SessionException;
use Kernel\Components\Exception\TPS\Exceptions\AuthenticationExpiredTpsException;
use Kernel\Components\Exception\Validation\ValidationException;
use Kernel\Entities\User\Tps\SubjectData;
use Kernel\Repositories\Interfaces\IdentityInterface;
use Kernel\ValueObjects\Token;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Throwable;
use Yiisoft\Session\SessionInterface;

readonly class SessionMiddleware implements MiddlewareInterface
{
    public function __construct(
        private SessionInterface $session,
        private Container $container
    ) {
    }

    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     * @throws AuthenticationExpiredTpsException
     * @throws DependencyException
     * @throws NotFoundException
     * @throws SessionException
     * @throws ValidationException
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            $this->setDataFromSession($request);
            return $handler->handle($request);
        } catch (SessionException | AuthenticationExpiredTpsException $exception) {
            $this->session->destroy();
            throw $exception;
        }
    }

    /**
     * @throws DependencyException
     * @throws NotFoundException
     * @throws ValidationException
     * @throws SessionException
     */
    private function setDataFromSession(ServerRequestInterface $request): void
    {
        $sessionId = $request->getHeader('Authorization')[0] ?? $request->getHeader('authorization')[0] ?? null;
        if (is_string($sessionId)) {
            $this->session->setId($sessionId);
        }
        $this->session->open();

        $user = $this->getUserFromSession();

        if ($user !== null) {
            /** @var Token $token */
            $token = $this->container->get(Token::class);
            $token->setToken($user->getAuthToken());

            $this->setCurrentUser($user);
            $this->setSocketData($user);
        }
    }

    /**
     * @throws SessionException
     */
    private function getUserFromSession(): ?SubjectData
    {
        $subjectData = $this->session->get('subjectData');
        if (!is_string($subjectData)) {
            return null;
        }
        try {
            /** @var SubjectData $user */
            $user = unserialize($subjectData);
            return $user;
        } catch (Throwable $exception) {
            throw new SessionException();
        }
    }

    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    private function setCurrentUser(SubjectData $subjectData): void
    {
        /** @var IdentityInterface $repository */
        $repository = $this->container->get(IdentityInterface::class);
        $repository->setSubjectData($subjectData);
    }

    private function setSocketData(SubjectData $user): void
    {
        $this->session->set('socketData', [
            'login' => $user->getLogin(),
            'roles' => $user->getRoles() ?? []
        ]);
    }
}
