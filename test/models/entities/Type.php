<?php

namespace app\models\entities;

use app\models\Entity;

class Type extends Entity
{
    public $id;
    readonly ?string $title;
    readonly ?string $mask;

    public function __construct(string $title = null, string $mask = null)
    {
        $this->title = $title;
        $this->mask = $mask;
    }
}