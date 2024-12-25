<?php

namespace Kernel\Repositories\Interfaces;

use Kernel\Entities\User\Tps\SubjectData;
use Kernel\ValueObjects\Token;

interface IdentityInterface
{
    /**
     * $token - Позволяет использовать токен авторизации не из DI
     */
    public function getUserIdentity(?Token $token = null): SubjectData;

    public function setSubjectData(SubjectData $subjectData): void;
}
