<?php

namespace Kernel\Components\Repository\Components\DB\MockEntity;

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use Kernel\Components\Repository\Components\DB\DbEntity;

/**
* Mock сущность для Cycle ORM
 */
#[Entity(table: 'mock')]
class MockDbEntity extends DbEntity
{
    public const SCHEME_NAME = 'mockDbEntity';

    public function __construct(
        #[Column(type: "integer", name: "id", primary: true)]
        private int $id
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }
}
