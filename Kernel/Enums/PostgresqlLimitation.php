<?php

namespace Kernel\Enums;

enum PostgresqlLimitation: int
{
    case INT_MAX_VALUE = 2147483647;
    case BIG_INT_MAX_VALUE = 9223372036854775807;
}
