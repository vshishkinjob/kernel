<?php

namespace Kernel\Components\Logger;

enum LogServiceEnum: string
{
    case Dd = 'db';
    case Tps = 'tps';
    case Method = 'method';
}
