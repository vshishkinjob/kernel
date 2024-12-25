<?php

namespace Unit\Kernel\Components\Filter\Access;

use Codeception\Stub\Expected;
use Codeception\Test\Unit;
use Kernel\Components\Config\ConfigFile;
use Kernel\Components\Exception\Http\ForbiddenException;
use Kernel\Components\Exception\TPS\Exceptions\NotAuthenticatedTpsException;
use Kernel\Components\Filter\Filters\AccessComponent\AccessComponent;
use Kernel\Components\Logger\KernelLoggerInterface;
use Kernel\Components\Method\MethodComponentInterface;
use Kernel\Components\RBAC\Permissions;
use Kernel\Components\RBAC\RBACHelper;
use Kernel\Components\RBAC\Roles;
use Kernel\Components\Repository\Components\Tps\TpsRepository;
use Kernel\Components\Request\RoutineInterface;
use Kernel\Entities\User\Tps\SubjectData;
use Kernel\Enums\User\SubjectType;
use Kernel\Repositories\Interfaces\IdentityInterface;
use Kernel\Repositories\Tps\GetCurrentSubjectDataRepository;
use Unit\Kernel\Components\Filter\Access\MockMethods\NoPermissionsMethod;
use Unit\Kernel\Components\Filter\Access\MockMethods\NoRbacMethod;
use Unit\Kernel\Components\Filter\Access\MockMethods\WithPermissionsMethod;

class AccessComponentTest extends Unit
{
    public function testMethodWithoutRbacInterface()
    {
        $methodComponent = $this->makeEmpty(MethodComponentInterface::class, [
            'getMethod' => function (RoutineInterface $routine) {
                return new NoRbacMethod();
            }
        ]);

        $component = $this->make(AccessComponent::class, [
            'methodComponent' => $methodComponent
        ]);

        $component->filter($this->makeEmpty(RoutineInterface::class));
    }

    public function testFilterWithoutPermission()
    {
        $userRepository = $this->makeEmpty(IdentityInterface::class, [
            'getUserIdentity' => new SubjectData(
               login: "some_login",
               id: 100,
               subjectType: SubjectType::MERCHANT,
               roles: [Roles::MERCHANT->value]
            ),
            'repository' => $this->makeEmpty(TpsRepository::class)
        ]);

        $methodComponent = $this->makeEmpty(MethodComponentInterface::class, [
            'getMethod' => function (RoutineInterface $routine) {
                return new NoPermissionsMethod();
            }
        ]);

        $config = $this->make(ConfigFile::class, [
            'configs' => [
                'allowedUserTypes' => [SubjectType::MERCHANT],
                'allowedUserPermissions' => [Permissions::ACCESS_PARTNER_CABINET]
            ]
        ]);

        $component = $this->make(AccessComponent::class, [
            'methodComponent' => $methodComponent,
            'rbacHelper' => new RBACHelper($config),
            'userRepository' => $userRepository
        ]);

        $request = $this->makeEmpty(RoutineInterface::class);

        $component->filter($request);
    }

    public function testSuccessWithPermission()
    {
        $userRepository = $this->makeEmpty(IdentityInterface::class, [
            'getUserIdentity' => new SubjectData(
                login: "some_login",
                id: 100,
                subjectType: SubjectType::MERCHANT,
                roles: [Roles::MERCHANT->value]
            ),
            'repository' => $this->makeEmpty(TpsRepository::class)
        ]);

        $methodComponent = $this->makeEmpty(MethodComponentInterface::class, [
            'getMethod' => function(RoutineInterface $routine) {
                return new WithPermissionsMethod();
            }
        ]);

        $config = $this->make(ConfigFile::class, [
            'configs' => [
                'allowedUserTypes' => [SubjectType::MERCHANT],
                'allowedUserPermissions' => [Permissions::ACCESS_PARTNER_CABINET]
            ]
        ]);

        $component = $this->make(AccessComponent::class, [
            'methodComponent' => $methodComponent,
            'rbacHelper' => new RBACHelper($config),
            'userRepository' => $userRepository,
            'logger' => $this->makeEmpty(KernelLoggerInterface::class)
        ]);

        $request = $this->makeEmpty(RoutineInterface::class);

        $component->filter($request);
    }

    public function testAccessDeniedForWrongUserPermissionInApp()
    {
        $userRepository = $this->makeEmpty(IdentityInterface::class, [
            'getUserIdentity' => new SubjectData(
                login: "some_login",
                id: 100,
                subjectType: SubjectType::MERCHANT,
                roles: [Roles::MERCHANT->value]
            ),
            'repository' => $this->makeEmpty(TpsRepository::class)
        ]);

        $methodComponent = $this->makeEmpty(MethodComponentInterface::class, [
            'getMethod' => function (RoutineInterface $routine) {
                return new WithPermissionsMethod();
            }
        ]);

        $config = $this->make(ConfigFile::class, [
            'configs' => [
                'allowedUserTypes' => [SubjectType::MERCHANT],
                'allowedUserPermissions' => [Permissions::ACCESS_PARTNER_CABINET]
            ]
        ]);

        $component = $this->make(AccessComponent::class, [
            'methodComponent' => $methodComponent,
            'rbacHelper' => $this->make(RBACHelper::class, [
                'configFile' => $config,
                'getUserPermissions' => function (SubjectData $data) {
                    return ['NOT_EXISTING_PERMISSION'];
                }
            ]),
            'userRepository' => $userRepository
        ]);

        $request = $this->makeEmpty(RoutineInterface::class);

        $this->expectException(ForbiddenException::class);
        $component->filter($request);
    }

    public function testAccessDeniedForWrongUserPermissionInMethod()
    {
        $userRepository = $this->makeEmpty(IdentityInterface::class, [
            'getUserIdentity' => new SubjectData(
                login: "some_login",
                id: 100,
                subjectType: SubjectType::MERCHANT,
                roles: [Roles::MERCHANT->value]
            ),
            'repository' => $this->makeEmpty(TpsRepository::class)
        ]);

        $methodComponent = $this->makeEmpty(MethodComponentInterface::class, [
            'getMethod' => function (RoutineInterface $routine) {
                return new WithPermissionsMethod();
            }
        ]);

        $config = $this->make(ConfigFile::class, [
            'configs' => [
                'allowedUserTypes' => [SubjectType::MERCHANT],
                'allowedUserPermissions' => [Permissions::ACCESS_PARTNER_CABINET]
            ]
        ]);

        $component = $this->make(AccessComponent::class, [
            'methodComponent' => $methodComponent,
            'rbacHelper' => $this->make(RBACHelper::class, [
                'configFile' => $config,
                'getUserPermissions' => function (SubjectData $data) {
                    return ['NOT_EXISTING_PERMISSION'];
                },
                'validateAppPermission' => function (SubjectData $data) {
                    return;
                }

            ]),
            'userRepository' => $userRepository,
            'logger' => $this->makeEmpty(KernelLoggerInterface::class)
        ]);

        $request = $this->makeEmpty(RoutineInterface::class);

        $this->expectException(ForbiddenException::class);
        $component->filter($request);
    }

    public function testAccessDeniedForWrongUserSubjectType()
    {
        $userRepository = $this->makeEmpty(IdentityInterface::class, [
            'getUserIdentity' => new SubjectData(
                login: "some_login",
                id: 100,
                subjectType: SubjectType::AGENT,
                roles: [Roles::MERCHANT->value]
            ),
            'repository' => $this->makeEmpty(TpsRepository::class)
        ]);

        $methodComponent = $this->makeEmpty(MethodComponentInterface::class, [
            'getMethod' => function (RoutineInterface $routine) {
                return new WithPermissionsMethod();
            }
        ]);

        $config = $this->make(ConfigFile::class, [
            'configs' => [
                'allowedUserTypes' => [SubjectType::MERCHANT],
                'allowedUserPermissions' => [Permissions::ACCESS_PARTNER_CABINET]
            ]
        ]);

        $component = $this->make(AccessComponent::class, [
            'methodComponent' => $methodComponent,
            'rbacHelper' => $this->make(RBACHelper::class, [
                'configFile' => $config
            ]),
            'userRepository' => $userRepository
        ]);

        $request = $this->makeEmpty(RoutineInterface::class);

        $this->expectException(ForbiddenException::class);
        $component->filter($request);
    }

    public function testAccessDeniedIfUserNotExistInSession()
    {
        $methodComponent = $this->makeEmpty(MethodComponentInterface::class, [
            'getMethod' => function(RoutineInterface $routine) {
                return new WithPermissionsMethod();
            }
        ]);

        $component = $this->make(AccessComponent::class, [
            'methodComponent' => $methodComponent,
            'userRepository' => $this->make(GetCurrentSubjectDataRepository::class, [
                'repository' => $this->makeEmpty(TpsRepository::class, [
                    'resolve' => function() {
                        throw new NotAuthenticatedTpsException();
                    }
                ])
            ])
        ]);

        $request = $this->makeEmpty(RoutineInterface::class);

        $this->expectException(NotAuthenticatedTpsException::class);
        $component->filter($request);
    }

    public function testInLoggerLoginWasSet()
    {
        $userRepository = $this->makeEmpty(IdentityInterface::class, [
            'getUserIdentity' => new SubjectData(
                login: 'SOME_LOGIN',
                id: 100,
                subjectType: SubjectType::MERCHANT,
                roles: [Roles::MERCHANT->value]
            ),
            'repository' => $this->makeEmpty(TpsRepository::class)
        ]);

        $methodComponent = $this->makeEmpty(MethodComponentInterface::class, [
            'getMethod' => function(RoutineInterface $routine) {
                return new WithPermissionsMethod();
            }
        ]);

        $config = $this->make(ConfigFile::class, [
            'configs' => [
                'allowedUserTypes' => [SubjectType::MERCHANT],
                'allowedUserPermissions' => [Permissions::ACCESS_PARTNER_CABINET]
            ]
        ]);

        $component = $this->make(AccessComponent::class, [
            'methodComponent' => $methodComponent,
            'rbacHelper' => new RBACHelper($config),
            'userRepository' => $userRepository,
            'logger' => $this->makeEmpty(KernelLoggerInterface::class, [
                'setLogin' => Expected::once('SOME_LOGIN')
            ])
        ]);

        $request = $this->makeEmpty(RoutineInterface::class);

        $component->filter($request);
    }
}
