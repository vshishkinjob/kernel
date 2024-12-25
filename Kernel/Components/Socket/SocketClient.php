<?php

namespace Kernel\Components\Socket;

use Kernel\Components\Exception\App\NotValidEntityException;
use Kernel\Components\Exception\Socket\SocketConnectionException;
use Kernel\Components\Exception\Socket\SocketCreateException;
use Socket;

/**
 * @infection-ignore-all
 */
class SocketClient
{
	const PORT = 3123;

	/**
	 * @throws SocketCreateException
	 * @throws SocketConnectionException
	 */
	public function connect(string $ip): Socket
	{
		$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
		if ($socket === false) {
			throw new SocketCreateException("socket_create() failed. Reason: " . socket_strerror(socket_last_error()));
		}
		socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, [
			"sec" => 5,
			"usec" => 0
		]);
		$connection = socket_connect($socket, $ip, self::PORT);
		if ($connection === false) {
			$errorMessage = socket_strerror(socket_last_error($socket));
			throw new SocketConnectionException("socket_connect() failed. Reason: " . $errorMessage);
		}
		return $socket;
	}

	/**
	 * @param Socket $connection
	 * @param array<array-key,mixed> $message
	 * @return void
	 * @throws NotValidEntityException
	 */
	public function sendTcpMessage(Socket $connection, array $message): void
	{
		$data = json_encode([
			"args" => $message,
			"name" => 'command'
		]);
		if (!is_string($data)) {
			throw new NotValidEntityException();
		}
		$length = strlen($data);
		while (true) {
			$writtenDataCount = socket_write($connection, $data, $length);

			if ($writtenDataCount === false) {
				break;
			}

			if ($writtenDataCount < $length) {
				$data = substr($data, $writtenDataCount);
				$length -= $writtenDataCount;
			} else {
				break;
			}
		}
	}
}
