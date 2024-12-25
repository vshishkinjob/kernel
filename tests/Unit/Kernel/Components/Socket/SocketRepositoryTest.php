<?php

namespace Unit\Kernel\Components\Socket;

use Codeception\Stub\Expected;
use Codeception\Test\Unit;
use Kernel\Components\RBAC\Roles;
use Kernel\Components\Repository\Components\Redis\RedisComponent;
use Kernel\Components\Socket\SocketClient;
use Kernel\Components\Socket\SocketRepository;
use Redis;
use Socket;

class SocketRepositoryTest extends Unit
{
    public function testSocketSendByLogins()
    {
        $logins = ['FIRST_LOGIN', 'SECOND_LOGIN'];
        $data = ["SOME_DATA"];
        $command = 'COMMAND_FROM_KERNEL';

        $redis = $this->make(RedisComponent::class, [
            'getClient' => $this->makeEmpty(Redis::class, [
                'zRange' => function (string $key, int $start, int $end) {
                    $this->assertEquals(0, $start);
                    $this->assertEquals(-1, $end);
                    $this->assertTrue(
                        in_array($key, ["WSSET:login:FIRST_LOGIN", "WSSET:login:SECOND_LOGIN"], strict: true)
                    );
                    return ['127.0.0.1'];
                }
            ])
        ]);

        $client = $this->makeEmpty(SocketClient::class, [
            'connect' => function (string $ip) {
                $this->assertEquals('127.0.0.1', $ip);
                return \socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
            },
            'sendTcpMessage' => Expected::exactly(2, function (Socket $socket, array $message) {
                $this->assertIsArray($message);
                $this->assertTrue(
                    in_array($message['receiver'], ['login:FIRST_LOGIN', 'login:SECOND_LOGIN'], strict: true)
                );
                $this->assertIsArray($message['data']);
                $this->assertEquals('SOME_DATA', $message['data']['data'][0]);
                $this->assertEquals('COMMAND_FROM_KERNEL', $message['data']['command']);
            })
        ]);

        $component = new SocketRepository($redis, $client);
        $component->sendByLogins($logins, $data, $command);
    }

    public function testSocketSendByRoles()
    {
        $roles = [Roles::MERCHANT->value, Roles::MERCHANT_CHIEF_ACCOUNTANT->value];
        $data = ["SOME_DATA"];
        $command = 'COMMAND_FROM_KERNEL';

        $redis = $this->make(RedisComponent::class, [
            'getClient' => $this->makeEmpty(Redis::class, [
                'zRange' => function (string $key, int $start, int $end) {
                    $this->assertEquals(0, $start);
                    $this->assertEquals(-1, $end);
                    $this->assertTrue(
                        in_array(
                            $key,
                            [
                                "WSSET:role:" . Roles::MERCHANT->value,
                                "WSSET:role:" . Roles::MERCHANT_CHIEF_ACCOUNTANT->value
                            ],
                            strict: true
                        )
                    );
                    return ['127.0.0.1'];
                }
            ])
        ]);

        $client = $this->makeEmpty(SocketClient::class, [
            'connect' => function (string $ip) {
                $this->assertEquals('127.0.0.1', $ip);
                return \socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
            },
            'sendTcpMessage' => Expected::exactly(2, function (Socket $socket, array $message) {
                $this->assertIsArray($message);
                $this->assertTrue(
                    in_array(
                        $message['receiver'],
                        ['role:' . Roles::MERCHANT->value, 'role:' . Roles::MERCHANT_CHIEF_ACCOUNTANT->value],
                        strict: true
                    )
                );
                $this->assertIsArray($message['data']);
                $this->assertEquals('SOME_DATA', $message['data']['data'][0]);
                $this->assertEquals('COMMAND_FROM_KERNEL', $message['data']['command']);
            })
        ]);

        $component = new SocketRepository($redis, $client);
        $component->sendByRoles($roles, $data, $command);
    }
}