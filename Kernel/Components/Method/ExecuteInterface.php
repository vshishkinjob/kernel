<?php

namespace Kernel\Components\Method;

interface ExecuteInterface
{
    /**
     * @psalm-suppress MissingReturnType
     */
    public function execute(AbstractDTO $dto);

    public function getMethodDto(): AbstractDTO;
}
