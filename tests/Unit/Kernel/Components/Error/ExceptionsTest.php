<?php

namespace Unit\Kernel\Components\Error;

use Codeception\Test\Unit;
use Kernel\Components\Exception\Exception;
use Kernel\Components\Exception\TPS\Exceptions\UserNotRegisteredTpsException;

class ExceptionsTest extends Unit
{
	private function getAllExceptionsNamespaces(string $dir = 'Kernel/Components/Exception'): array
	{
		$namespaces = [];

		// Получаем список файлов в папке
		$files = scandir($dir);

		// Итерируем по файлам
		foreach ($files as $file) {
			// Исключаем текущую и родительскую директории
			if ($file == '.' || $file == '..') {
				continue;
			}

			$filePath = $dir . '/' . $file;

			if (is_dir($filePath)) {
				$namespaces = array_merge($namespaces, $this->getAllExceptionsNamespaces($filePath));
				continue;
			}

			// Полный путь к файлу


			// Проверяем, является ли файл PHP-файлом
			if (is_file($filePath) && pathinfo($file, PATHINFO_EXTENSION) == 'php') {
				// Получаем содержимое файла
				$content = file_get_contents($filePath);

				// Ищем строку с объявлением namespace
				preg_match('/namespace\s+(.*?);/', $content, $matches);

				// Если найдено, добавляем в коллекцию
				if (isset($matches[1])) {
					$className = $matches[1] . '\\' . pathinfo($filePath, PATHINFO_FILENAME);
					$reflection = new \ReflectionClass($className);
					if ($reflection->isInstantiable() && $reflection->isSubclassOf(Exception::class)) {
						$namespaces[] = $className;
					}
				}
			}
		}

		return $namespaces;
	}

	public function testTpsExceptionDir()
	{
		$tpsExceptionsFolder = 'Kernel/Components/Exception/TPS/Exceptions';
		$this->assertNotEmpty(scandir($tpsExceptionsFolder));
	}

	public function testTpsException()
	{
		$exception = new UserNotRegisteredTpsException();
		$this->assertEquals(3003, $exception->getCode());
	}

	public function testCheckExceptionsConstructor()
	{
		$collection = $this->getAllExceptionsNamespaces();
		foreach ($collection as $className) {
			$exception = new $className(message: 'message', additionalData: ['test']);
			$this->assertEquals('message', $exception->getMessage());
			$this->assertEquals(['test'], $exception->getAdditionalData());
		}
	}
}