<?php

namespace Kernel\Components\Socket;

use Kernel\Components\Exception\App\NotValidEntityException;
use Kernel\Components\Exception\Socket\SocketConnectionException;
use Kernel\Components\Exception\Socket\SocketCreateException;
use Kernel\Components\RBAC\Roles;
use Kernel\Components\Repository\Components\Redis\RedisComponent;
use RedisException;

final readonly class SocketRepository implements SocketInterface
{
    public function __construct(
        private RedisComponent $redisComponent,
        private SocketClient $client
    ) {
    }

    /**
     * @inheritDoc
     * @throws SocketConnectionException
     * @throws SocketCreateException
     * @throws RedisException
     * @throws NotValidEntityException
     */
    public function sendByLogins(array $logins, array $data, string $command): void
    {
        $ipList = $this->getReceiverIpMap($logins, 'login');
        foreach ($ipList as $receiver => $ips) {
            $this->sendToReceivers($ips, 'login', $receiver, $command, $data);
        }
    }

    /**
     * @inheritDoc
     * @throws SocketConnectionException
     * @throws SocketCreateException
     * @throws RedisException
     * @throws NotValidEntityException
     */
    public function sendByRoles(array $roles, array $data, string $command): void
    {
        $ipList = $this->getReceiverIpMap($roles, 'role');
        foreach ($ipList as $receiver => $ips) {
            $this->sendToReceivers($ips, 'role', $receiver, $command, $data);
        }
    }

    /**
     * @param list<string>|list<value-of<Roles::*>> $receivers
     * @return array<string,list<string>>
     * @throws RedisException
     */
    private function getReceiverIpMap(array $receivers, string $receiverType): array
    {
        $ipList = [];
        $redisClient = $this->redisComponent->getClient();
        foreach ($receivers as $receiver) {
            /**
             * @var list<string> $list
             */
            $list = $redisClient->zRange("WSSET:$receiverType:$receiver", 0, -1);
            $ipList[$receiver] = $list;
        }
        return $ipList;
    }

    /**
     * @param list<string> $ips
     * @param array<array-key,mixed> $data
     * @throws SocketConnectionException
     * @throws SocketCreateException
     * @throws NotValidEntityException
     */
    private function sendToReceivers(
        array $ips,
        string $receiverType,
        string $receiver,
        string $command,
        array $data
    ): void {
        $message = $this->getMessage($receiverType, $receiver, $command, $data);
        foreach ($ips as $ip) {
            $connection = $this->client->connect($ip);
            $this->client->sendTcpMessage($connection, $message);
        }
    }

    /**
     * @param array<array-key,mixed> $data
     * @return array<array-key,mixed>
     */
    private function getMessage(string $receiverType, string $receiver, string $command, array $data): array
    {
        return [
            'receiver' => "$receiverType:$receiver",
            'data' => [
                'data' => $data,
                'command' => $command,
            ],
        ];
    }
}
