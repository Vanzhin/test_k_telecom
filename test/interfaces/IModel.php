<?php

namespace app\interfaces;
interface IModel
{
    public function getOne(int $id);

    public function getAll();

    public function getTableName();


}