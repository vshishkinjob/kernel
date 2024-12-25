<?php

declare(strict_types=1);

namespace Kernel\Components\Request;

class ServerSuperGlobalHelper
{
    //Взято из старых кабинетов. Возможно бесполезно или нужно рефакторить!
    public static function getUserHostAddress(): string
    {
        if (isset($_SERVER['PHP_AUTH_IP'])) {
            return $_SERVER['PHP_AUTH_IP'];
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            return $_SERVER['REMOTE_ADDR'];
        }
        return '127.0.0.1';
    }
}
