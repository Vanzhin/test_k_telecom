<?php

namespace app\models\repositories;

use app\models\entities\Equipment;
use app\models\Repository;

class EquipmentRepository extends Repository
{

    public function getTableName(): string
    {
        return 'equipment';
    }

    public function getEntityClass(): string
    {
        return Equipment::class;
    }



}