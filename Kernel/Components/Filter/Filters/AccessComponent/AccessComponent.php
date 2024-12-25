<?php

namespace Kernel\Components\Filter\Filters\AccessComponent;

use Kernel\Components\Exception\Http\ForbiddenException;
use Kernel\Components\Filter\FilterInterface;
use Kernel\Components\Logger\KernelLoggerInterface;
use Kernel\Components\Method\MethodComponentInterface;
use Kernel\Components\RBAC\Permissions;
use Kernel\Components\RBAC\RBACHelper;
use Kernel\Components\Request\RoutineInterface;
use Kernel\Entities\User\Tps\SubjectData;
use Kernel\Repositories\Interfaces\IdentityInterface;

final readonly class AccessComponent implements FilterInterface
{
    public function __construct(
        private MethodComponentInterface $methodComponent,
        private KernelLoggerInterface $logger,
        private IdentityInterface $userRepository,
        private RBACHelper $rbacHelper
    ) {
    }

	/**
	 * @throws ForbiddenException
	 */
    public function filter(RoutineInterface $request): void
    {
        $method = $this->methodComponent->getMethod($request);
        if ($method instanceof RbacInterface) {
            $subjectData = $this->userRepository->getUserIdentity();
            $this->rbacHelper->validateAppSubjectType($subjectData);
            $this->rbacHelper->validateAppPermission($subjectData);
            $methodPermissions = $this->getPermissionValues($method->getPermissions());
            if (!empty($methodPermissions)) {
                $this->logger->setLogin($subjectData->getLogin());
                $this->validateMethodPermissions($methodPermissions, $subjectData);
            }
        }
    }

    /**
     * @param array<value-of<Permissions::*>> $methodPermissions
     * @throws ForbiddenException
     */
    private function validateMethodPermissions(array $methodPermissions, SubjectData $user): void
    {
        $userPermissions = $this->rbacHelper->getUserPermissions($user);
        if (empty(array_intersect($methodPermissions, $userPermissions))) {
            throw new ForbiddenException();
        }
    }

    /**
     * @param list<Permissions> $getPermissions
     * @return array<value-of<Permissions::*>>
     */
    private function getPermissionValues(array $getPermissions): array
    {
        $values = [];
        foreach ($getPermissions as $permission) {
            $values[] = $permission->value;
        }
        return $values;
    }
}
