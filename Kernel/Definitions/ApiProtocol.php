<?php

namespace Kernel\Definitions;

enum ApiProtocol: string
{
	case JSONRPC = 'JsonRpc';
	case REST = 'Rest';
}
