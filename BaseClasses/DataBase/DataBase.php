<?php

namespace testFullStackDev\BaseClasses\DataBase;

use PDO;
use PDOStatement;

class DataBase extends Connection
{
    /**
     * @var PDO
     */
    protected $pdo;

    public function __construct()
    {
        parent::__construct();
        $this->pdo = $this->getPdo();
    }

    /**
     * @param string $sql
     * @param array $params
     * @return false|PDOStatement
     */
    public function query(string $sql, array $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
}