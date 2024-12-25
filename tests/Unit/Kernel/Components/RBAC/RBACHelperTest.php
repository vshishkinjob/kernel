<?php

namespace Unit\Kernel\Components\RBAC;

use Codeception\Test\Unit;
use Kernel\Components\Config\ConfigFile;
use Kernel\Components\Exception\Http\ForbiddenException;
use Kernel\Components\RBAC\Permissions;
use Kernel\Components\RBAC\RBACHelper;
use Kernel\Components\RBAC\Roles;
use Kernel\Entities\User\Tps\SubjectData;
use Kernel\Enums\User\SubjectType;

class RBACHelperTest extends Unit
{
    public function testFailWithIncorrectAppSubjectType()
    {
        $config = new ConfigFile(['allowedUserTypes' => [SubjectType::MERCHANT]]);
        $helper = new RBACHelper($config);
        $this->expectException(ForbiddenException::class);
        $helper->validateAppSubjectType($this->makeEmpty(SubjectData::class, ["subjectType" => SubjectType::AGENT]));
    }

    public function testFailWithIncorrectAppPermission()
    {
        $config = new ConfigFile(['allowedUserPermissions' => [Permissions::ACCESS_PARTNER_CABINET]]);
        $helper = new RBACHelper($config);
        $this->expectException(ForbiddenException::class);
        $helper->validateAppPermission($this->makeEmpty(SubjectData::class, ["roles" => [Roles::BOOKMAKER_SPP_MERCHANT->value]]));
    }

    public function testSuccessfullyGetUserPermissions()
    {
        $config = new ConfigFile([]);
        $helper = new RBACHelper($config);
        $permissions = $helper->getUserPermissions($this->make(SubjectData::class, ["roles" => [Roles::BOOKMAKER_SPP_MERCHANT->value]]));
        $this->assertEquals([
            0 => 'oAccessBookmakerSppCabinet',
            1 => 'oCheckInvoices',
            2 => 'oGetCardOperationInfo',
            3 => 'oGetOperationDataByExtId',
            4 => 'oGetOwnStorningOperations',
            5 => 'oViewParentsOperations',
        ], $permissions);
    }
}
