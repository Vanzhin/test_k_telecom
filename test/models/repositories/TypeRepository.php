<?php

namespace app\models\repositories;

use app\models\entities\Type;
use app\models\Repository;

class TypeRepository extends Repository
{

    function getTableName(): string
    {
        return 'types';
    }

    function getEntityClass(): string
    {
        return Type::class;
    }
}