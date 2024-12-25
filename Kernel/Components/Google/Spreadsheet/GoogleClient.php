<?php

namespace Kernel\Components\Google\Spreadsheet;

use Google\Exception;
use Google\Service\Sheets;
use Google_Client;
use Google_Service_Sheets;
use Kernel\Components\Config\ConfigFile;

final class GoogleClient extends Google_Client
{
    private const NAME = 'Woopkassa Feedback Manager';
    private const ACCESS_TYPE = 'offline';

    public function __construct(private readonly string $authCredentialsPath)
    {
        parent::__construct([
            'application_name' => self::NAME,
            'scopes' => [Sheets::SPREADSHEETS],
            'access_type' => self::ACCESS_TYPE,
            'credentials' => $this->authCredentialsPath
        ]);
    }
}
