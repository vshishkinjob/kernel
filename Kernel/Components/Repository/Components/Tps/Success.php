<?php

namespace Kernel\Components\Repository\Components\Tps;

enum Success: int
{
    case TPS_SUCCESS_CODE = 0;

    case TPS_SUCCESS_RESTORE_DELETED_CODE = 1;
}
