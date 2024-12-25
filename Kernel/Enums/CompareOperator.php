<?php

namespace Kernel\Enums;

enum CompareOperator: string
{
    case MORE = ">";
    case MORE_OR_EQUAL = ">=";
    case LESS = "<";
    case LESS_OR_EQUAL = "<=";
    case EQUAL = "=";
    case NOT_EQUAL = '!==';
}
