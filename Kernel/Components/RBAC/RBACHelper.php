<?php

namespace Kernel\Components\RBAC;

use Kernel\Components\Config\ConfigFile;
use Kernel\Components\Exception\App\EmptyDataException;
use Kernel\Components\Exception\Http\ForbiddenException;
use Kernel\Entities\User\Tps\SubjectData;
use Kernel\Enums\User\SubjectType;

final readonly class RBACHelper
{
    public function __construct(private ConfigFile $configFile)
    {
    }

    /**
     * @return array<int,string>
     * @throws EmptyDataException
     */
    public function getUserPermissions(SubjectData $user): array
    {
        $userRoles = $user->getRoles();
        if (!isset($userRoles)) {
            return [];
        }
        if (file_exists(__DIR__ . '/items.php')) {
            $items = include __DIR__ . '/items.php';
        }
        if (!isset($items) || !is_array($items)) {
            $items = include __DIR__ . '/items-local.php';
        }
        if (!is_array($items)) {
            throw new EmptyDataException('Отсутствует RBAC файл!');
        }
        $userPermissions = [];
        foreach ($userRoles as $role) {
            if (isset($items[$role]['children'])) {
                foreach ($items[$role]['children'] as $children) {
                    /** @var string $children */
                    if ($children[0] == 'o') {
                        $userPermissions[] = $children;
                    }
                }
            }
        }
        /** @var array<int, string> $userPermissions */
        $userPermissions = array_unique($userPermissions);
        return $userPermissions;
    }

    /**
     * @throws ForbiddenException
     */
    public function validateAppSubjectType(SubjectData $user): void
    {
        /** @var list<SubjectType> $allowedTypes */
        $allowedTypes = $this->configFile->getConfigByKey('allowedUserTypes');
        if (!empty($allowedTypes) && !in_array($user->getSubjectType(), $allowedTypes, true)) {
            throw new ForbiddenException();
        }
    }

    /**
     * @throws ForbiddenException|EmptyDataException
     */
    public function validateAppPermission(SubjectData $user): void
    {
        $userPermissions = $this->getUserPermissions($user);
        /** @var list<Permissions> $rawAppPermissions */
        $rawAppPermissions = $this->configFile->getConfigByKey('allowedUserPermissions');
        $appPermissions = [];
        foreach ($rawAppPermissions as $permission) {
            $appPermissions[] = $permission->value;
        }
        if (!empty($appPermissions) && empty(array_intersect($appPermissions, $userPermissions))) {
            throw new ForbiddenException();
        }
    }
}
