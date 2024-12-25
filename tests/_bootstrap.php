<?php

use DG\BypassFinals;
use Kernel\Components\Sentry;
use Kernel\Definitions\Environment;

require_once __DIR__ . '/../vendor/tecnickcom/tcpdf/config/tcpdf_config.php';
require_once __DIR__ . '/../vendor/autoload.php';

const ENVIRONMENT = Environment::DEVELOP;

BypassFinals::enable();

Sentry::init(
    'https://some_sentry@sentry.test.wooppay.com/9',
    ['sensitive'],
    'some_current_url'
);