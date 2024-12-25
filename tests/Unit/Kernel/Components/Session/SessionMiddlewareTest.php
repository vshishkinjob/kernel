<?php

namespace Unit\Kernel\Components\Session;

use Codeception\Stub\Expected;
use Codeception\Test\Unit;
use DI\Container;
use Kernel\Components\Exception\Session\SessionException;
use Kernel\Components\Exception\TPS\Exceptions\AuthenticationExpiredTpsException;
use Kernel\Components\Repository\Components\Tps\TpsRepository;
use Kernel\Components\Response\ResponseFactory;
use Kernel\Components\Session\SessionMiddleware;
use Kernel\Entities\User\Tps\SubjectData;
use Kernel\Repositories\Interfaces\IdentityInterface;
use Kernel\Repositories\Tps\GetCurrentSubjectDataRepository;
use Kernel\ValueObjects\Token;
use Psr\Http\Message\ServerRequestInterface;
use Slim\MiddlewareDispatcher;
use Yiisoft\Session\Session;


class SessionMiddlewareTest extends Unit
{
    protected function _before()
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
        ResponseFactory::reset();;
        parent::_before();
    }

    public function testSessionSetSuccessfullyWithoutAuthorization()
    {
        $handler = $this->makeEmpty(MiddlewareDispatcher::class, [
            'handle' => ResponseFactory::getResponse()
        ]);

        $session = new Session();
        $session->set(
            'subjectData',
            serialize($this->make(SubjectData::class, ['login' => 'LOGIN_LOGIN', 'token' => 'SOME_TOKEN', 'roles' => ['SOME_ROLE']]))
        );

        $session->close();

        $session->setId('NOT_EXIST_KEY');
        $this->assertNull($session->get('subjectData'));
        $session->close();

        $container = new Container();
        $container->set(
            IdentityInterface::class,
            new GetCurrentSubjectDataRepository(
                $this->makeEmpty(TpsRepository::class, [
                    'resolve' => Expected::never()
                ])
            )
        );

        $rawRequest = $this->makeEmpty(ServerRequestInterface::class, [
            'getHeader' => function (string $header) {
                return [];
            }
        ]);
        $sessionMiddleware = new SessionMiddleware(
            $session,
            $container
        );

        $sessionMiddleware->process($rawRequest, $handler);

        $this->assertEquals(null, $container->get(Token::class)->getValue());
        $this->assertEmpty($session->get('subjectData'));
        $this->assertEmpty($session->get('socketData'));
    }

    public function testSessionSetSuccessfullyWithAuthorization()
    {
        $handler = $this->makeEmpty(MiddlewareDispatcher::class, [
            'handle' => ResponseFactory::getResponse()
        ]);

        $session = new Session();
        $session->set(
            'subjectData',
            serialize($this->make(SubjectData::class, ['login' => 'LOGIN_LOGIN', 'token' => 'SOME_TOKEN', 'roles' => ['SOME_ROLE']]))
        );
        $sessionId = $session->getId();
        $session->close();

        $session->setId('NOT_EXIST_KEY');
        $this->assertNull($session->get('subjectData'));
        $session->close();

        $container = new Container();
        $container->set(
            IdentityInterface::class,
            new GetCurrentSubjectDataRepository(
                $this->makeEmpty(TpsRepository::class, [
                    'resolve' => Expected::never()
                ])
            )
        );

        $rawRequest = $this->makeEmpty(ServerRequestInterface::class, [
            'getHeader' => function (string $header) use ($sessionId) {
                $this->assertEquals('Authorization', $header);
                return [$sessionId];
            }
        ]);
        $sessionMiddleware = new SessionMiddleware(
            $session,
            $container
        );

        $sessionMiddleware->process($rawRequest, $handler);

        $this->assertEquals('SOME_TOKEN', $container->get(Token::class)->getValue());


        $this->assertNotEmpty($session->get('subjectData'));
        $this->assertEquals('LOGIN_LOGIN', unserialize($session->get('subjectData'))->getLogin());
        $this->assertEquals('LOGIN_LOGIN', $container->get(IdentityInterface::class)->getUserIdentity()->getLogin());

        $this->assertNotEmpty($session->get('socketData'));
        $this->assertEquals('LOGIN_LOGIN', $session->get('socketData')['login']);
        $this->assertEquals(['SOME_ROLE'], $session->get('socketData')['roles']);
    }

    public function testSessionException()
	{

        $handler = $this->makeEmpty(MiddlewareDispatcher::class, [
            'handle' => function (ServerRequestInterface $request) {
                throw new SessionException();
            }
        ]);

        $session = new Session();
        $session->set(
            'subjectData',
            serialize($this->make(SubjectData::class, ['login' => 'LOGIN_LOGIN', 'token' => 'SOME_TOKEN', 'roles' => ['SOME_ROLE']]))
        );

        $session->close();

        $session->setId('NOT_EXIST_KEY');
        $this->assertNull($session->get('subjectData'));
        $session->close();

        $container = new Container();
        $container->set(
            IdentityInterface::class,
            new GetCurrentSubjectDataRepository(
                $this->makeEmpty(TpsRepository::class, [
                    'resolve' => Expected::never()
                ])
            )
        );

        $rawRequest = $this->makeEmpty(ServerRequestInterface::class, [
            'getHeader' => function (string $header) {
                return [];
            }
        ]);

        $sessionMiddleware = new SessionMiddleware(
            $session,
            $container
        );

		try {
			$sessionMiddleware->process($rawRequest, $handler);
		} catch (SessionException $exception) {
			$this->assertFalse($session->isActive());
			$this->assertEquals(null,$session->getId());
			return;
		}
		$this->fail();
	}

	public function testAuthenticationExpiredTpsException()
	{
        $handler = $this->makeEmpty(MiddlewareDispatcher::class, [
            'handle' => function (ServerRequestInterface $request) {
                throw new AuthenticationExpiredTpsException();
            }
        ]);

        $session = new Session();
        $session->set(
            'subjectData',
            serialize($this->make(SubjectData::class, ['login' => 'LOGIN_LOGIN', 'token' => 'SOME_TOKEN', 'roles' => ['SOME_ROLE']]))
        );

        $session->close();

        $session->setId('NOT_EXIST_KEY');
        $this->assertNull($session->get('subjectData'));
        $session->close();

        $container = new Container();
        $container->set(
            IdentityInterface::class,
            new GetCurrentSubjectDataRepository(
                $this->makeEmpty(TpsRepository::class, [
                    'resolve' => Expected::never()
                ])
            )
        );

        $rawRequest = $this->makeEmpty(ServerRequestInterface::class, [
            'getHeader' => function (string $header) {
                return [];
            }
        ]);

        $sessionMiddleware = new SessionMiddleware(
            $session,
            $container
        );

		try {
			$sessionMiddleware->process($rawRequest, $handler);
		} catch (AuthenticationExpiredTpsException $exception) {
			$this->assertFalse($session->isActive());
			$this->assertEquals(null,$session->getId());
			return;
		}
		$this->fail();
	}

}