<?php

namespace app\models\entities;

use app\models\Entity;

class Equipment extends Entity
{
    public $id;
    readonly ?int $type_id;
    readonly ?string $serial;


    public function __construct(int $type_id = null, $serial = null)
    {
        $this->type_id = $type_id;
        $this->serial = $serial;
    }
}