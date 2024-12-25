<?php

namespace Kernel\Components\Static;

use Kernel\Components\Exception\App\EmptyDataException;
use Kernel\Components\Exception\App\NotLoadedExtensionException;
use Kernel\Components\Exception\Exception;
use Kernel\Components\Exception\File\FileNotFoundException;
use Kernel\Components\Exception\SSH\ConnectionFailedSSHException;
use Kernel\Components\Exception\SSH\CreateDirectorySSHException;
use Kernel\Components\Exception\SSH\InvalidCredentialsSSHException;
use Kernel\Components\Exception\SSH\UnlinkSSHException;
use Kernel\Components\Exception\SSH\UploadFileSSHException;
use Kernel\Components\Exception\Validation\ValidationException;
use Kernel\Definitions\StaticConfig;
use Kernel\ValueObjects\Url;

final readonly class StaticRepository implements StaticInterface
{
	public function __construct(private StaticConfig $config)
	{
	}

    /**
     * @psalm-suppress InvalidArgument
     * @phan-suppress PhanTypeMismatchArgumentInternal
     * @inheritDoc
     * @throws \Exception|FileNotFoundException|UploadFileSSHException
     */
    public function uploadRawFiles(iterable $files, string $remoteFolder): StaticFileCollection
    {
        if (iterator_count($files) === 0) {
            throw new EmptyDataException();
        }
        $staticFileCollection = new StaticFileCollection();
        foreach ($files as $file) {
            $staticFileCollection->add(new StaticFile(
                $this->config->resourcePath,
                $this->config->staticUrl,
                $remoteFolder,
                StaticFile::createFileStaticName($file->getFilename()),
                $file->getFilename(),
                $file->getFileFullPath(),
            ));
        }
        $this->uploadFiles($staticFileCollection);
        return $staticFileCollection;
    }

    /**
     * @throws ConnectionFailedSSHException
     * @throws InvalidCredentialsSSHException
     * @throws UnlinkSSHException
     * @throws ValidationException
     */
    public function deleteRemoteFile(Url $fileUrl): void
    {
        $file = StaticFile::createFromUrl(
            $fileUrl,
            $this->config->resourcePath,
            $this->config->staticUrl,
        );

        $connection = $this->connect();
        $sftp = ssh2_sftp($connection);

        if ($sftp === false || !ssh2_sftp_unlink($sftp, $file->getStaticFullPath())) {
            throw new UnlinkSSHException('Произошла ошибка при удалении изображения с сервера!');
        }

        ssh2_exec($connection, 'exit');
    }

	/**
     * @infection-ignore-all
	 * @return resource
	 * @throws ConnectionFailedSSHException
	 * @throws InvalidCredentialsSSHException
	 */
	private function connect()
	{
		$connection = ssh2_connect($this->config->address, $this->config->port);

		if (!is_resource($connection)) {
			throw new ConnectionFailedSSHException();
		}

		if (
			!ssh2_auth_pubkey_file(
				$connection,
				$this->config->username,
				$this->config->publicKeyPath,
				$this->config->privateKeyPath,
                $this->config->passphrase
			)
		) {
			throw new InvalidCredentialsSSHException();
		}

		return $connection;
	}

	/**
     * @infection-ignore-all
	 * Загружает файлы в статик сервер
	 * @throws Exception
	 * @throws FileNotFoundException
	 */
	private function uploadFiles(StaticFileCollection $staticFileCollection): void
	{
		if ($staticFileCollection->isEmpty()) {
			throw new EmptyDataException();
		}
		$this->checkSsh2ExtensionsExist();
		$connection = $this->connect();
		$this->createRemoteDir($connection, $staticFileCollection);
		$this->uploadFilesToStatic($staticFileCollection, $connection);
		ssh2_exec($connection, 'exit');
	}

    /**
     * @infection-ignore-all
     * @param resource $connection
     * @throws FileNotFoundException
     * @throws UploadFileSSHException
     */
	private function uploadFilesToStatic(StaticFileCollection $staticFileCollection, $connection): void
	{
		foreach ($staticFileCollection as $file) {
			if (!ssh2_scp_send($connection, $file->getLocalFullFilePath(), $file->getStaticFullPath(), 0640)) {
                throw new UploadFileSSHException();
            }
		}
	}

	/**
     * @infection-ignore-all
	 * @param resource $connection
	 * @throws ConnectionFailedSSHException|CreateDirectorySSHException
	 */
	private function createRemoteDir($connection, StaticFileCollection $staticFileCollection): void
	{
		$sftp = $this->sftpConnect($connection);
		if (!ssh2_sftp_mkdir($sftp, $staticFileCollection[0]->getStaticDirectoryPath(), 0750, true)) {
            throw new CreateDirectorySSHException();
        }
	}

	/**
     * @infection-ignore-all
	 * @throws NotLoadedExtensionException
	 */
	private function checkSsh2ExtensionsExist(): void
	{
		if (!extension_loaded('ssh2')) {
			throw new NotLoadedExtensionException("extension ssh2 doesn't exist");
		}
	}

	/**
     * @infection-ignore-all
	 * @param resource $ssh2Connection
	 * @return resource
	 * @throws ConnectionFailedSSHException
	 */
	private function sftpConnect($ssh2Connection)
	{
		$sftp = ssh2_sftp($ssh2Connection);
		if (!is_resource($sftp)) {
			throw new ConnectionFailedSSHException();
		}
		return $sftp;
	}
}
