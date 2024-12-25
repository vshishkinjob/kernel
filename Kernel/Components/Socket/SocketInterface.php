<?php

namespace Kernel\Components\Socket;

use Kernel\Components\RBAC\Roles;

interface SocketInterface
{
	/**
	 * @param list<string> $logins
	 * @param array<array-key,mixed> $data
	 */
	public function sendByLogins(array $logins, array $data, string $command): void;

	/**
	 * @param list<value-of<Roles::*>> $roles
	 * @param array<array-key,mixed> $data
	 */
	public function sendByRoles(array $roles, array $data, string $command): void;
}
