<?php

namespace app\engine;
use app\traits\TSingleton;

class Db
{
    public array $config = [
        'driver' => 'mysql',
        'host' => 'db-master',
        'login' => 'test_master',
        'password' => 'xSc1jnBR6r8GW9gQgNvdKsVqGDqm5l',
        'database' => 'test',
        'charset' => 'utf8',
    ];
    private \PDO|null $connection = null;


    use TSingleton;

    private function getConnection(): \PDO
    {
        if (is_null($this->connection)){
            $this->connection = new \PDO(
                $this->prepareDsnString(),
                $this->config['login'],
                $this->config['password']);
                $this->connection->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
        }
        return $this->connection;
    }


    private function prepareDsnString(): string
    {
        return sprintf("%s:host=%s;dbname=%s;charset=%s",
            $this->config['driver'],
            $this->config['host'],
            $this->config['database'],
            $this->config['charset'],
        );
    }
    private function query($sql, $params): bool|\PDOStatement
    {
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute($params);
        return $stmt;

    }

    public function queryLimit($sql, $rowFrom, $quantity): bool|\PDOStatement
    {
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindValue(':rowFrom', $rowFrom, \PDO::PARAM_INT);
        $stmt->bindValue(':quantity', $quantity, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;

    }


    public function lastInsertId(): string
    {
        return $this->getConnection()->lastInsertId();
    }

    public function queryOneResult(string $sql, array $params = []): mixed
    {
        return $this->query($sql, $params)->fetch();
    }

    public function queryOneObject(string $sql, array $params, string $class): mixed
    {
        $stmt = $this->query($sql, $params);
        $stmt->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, $class);
        return $stmt->fetch();
    }

    public function queryAll(string $sql, array $params = []): bool|array
    {
        return $this->query($sql, $params)->fetchAll();
    }


    public function execute(string $sql, array $params = []): int
    {
        return $this->query($sql, $params)->rowCount();
    }


}