<?php

namespace app\models;

use app\engine\Db;

abstract class Repository

{
    abstract function getTableName() : string;
    abstract function getEntityClass() : string;

    public function save(Entity $entity): void
    {
        if(is_null($entity->id)){
            $this->insert($entity);
        } else{
            $this->update($entity);
        }
    }

    public function getOne($id): Entity
    {
        $sql = "SELECT * FROM {$this->getTableName()} WHERE id = :id";
        //        return Db::getInstance()->queryOneResult($sql, ['id' => $id]);
        //        метод queryOneObject возвращает полноценный объект с заполненными из БД свойствами, указанного класса
        $obj = Db::getInstance()->queryOneObject($sql, ['id' => $id], $this->getEntityClass());
        // создаю массив с перечислением свойств из БД
        $obj->createProps($obj);
        return $obj;
    }

    public function getAll():array
    {
        $sql = "SELECT * FROM {$this->getTableName()}";
        return Db::getInstance()->queryAll($sql);
    }

    public function getAllWhere(string $field, string|int $value): array
    {
        $sql = "SELECT * FROM {$this->getTableName()} WHERE {$field} = :value";
        return Db::getInstance()->queryAll($sql,['value' => $value]);
    }

    public function getCount(): int
    {
        $sql = "SELECT COUNT(*) FROM {$this->getTableName()}";
        return Db::getInstance()->queryAll($sql);
    }

    public function getCountWhere(string $field, string|int $value): int
    {
        $sql = "SELECT COUNT(*) AS count FROM {$this->getTableName()} WHERE $field = :value;";
        return Db::getInstance()->queryAll($sql, ['value' => $value]);

    }

    public function getOneWhere(string $name, string|int $value): mixed
    {
        $sql = "SELECT * FROM {$this->getTableName()} WHERE {$name} = :value";
        return Db::getInstance()->queryOneResult($sql, ['value' => $value]);
    }

    public function getIdWhere($name, $value):int
    {
        $sql = "SELECT id FROM {$this->getTableName()} WHERE {$name} = :value";
        return Db::getInstance()->queryOneResult($sql, ['value' => $value]);
    }

    public function getOneObjWhere($wheres = []): Entity
    {
        $sql = "SELECT * FROM {$this->getTableName()}";
        if (!empty($wheres)) {
            $sql .= " WHERE ";
            foreach ($wheres as $key => $value) {
                $sql .= $key . " = :" . $key;
                if ($value != end($wheres)) $sql .= " AND ";
            }
        }

        $obj = Db::getInstance()->queryOneObject($sql, $wheres, $this->getEntityClass());
        if ($obj){
            $obj->createProps($obj);
        }
        return $obj;
    }

    public function insert(Entity $entity): void
    {
        $params = [];
        foreach ($entity as $key => $value){
            if (is_null($value) || $key === 'propsFromDb') continue;
            $params[$key] = $value;
        }
        $keysToString = implode(", ", array_keys($params));
        $placeholders = ":" . implode(", :", array_keys($params));
        $sql = "INSERT INTO {$this->getTableName()} ({$keysToString}) VALUES ({$placeholders});";
        Db::getInstance()->execute($sql, $params);
        $entity->id = Db::getInstance()->lastInsertId();

    }

    public function delete(Entity $entity): void
    {
        $id = $entity->id;
        $sql = "DELETE FROM {$this->getTableName()} WHERE id = :id;";
        Db::getInstance()->execute($sql, ['id' => $id]);
    }

    public function update(Entity $entity): void
    {
        $id = $entity->id;
        $valuesToUpdate = [];
        foreach ($entity->propsFromDb as $key => $value){

            if ($value === '') continue;
            $valuesToUpdate[$key] = $key . "='" . $entity->$key . "'";
        }
        if(!empty($valuesToUpdate)){
            $updatedToString = implode(", ", $valuesToUpdate);
            $sql = "UPDATE {$this->getTableName()} SET {$updatedToString} WHERE id = :id;";
            Db::getInstance()->execute($sql, ['id' => $id]);
        }
    }
}