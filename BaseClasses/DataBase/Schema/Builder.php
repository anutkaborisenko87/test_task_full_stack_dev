<?php

namespace testFullStackDev\BaseClasses\DataBase\Schema;

use testFullStackDev\BaseClasses\DataBase\DataBase;

class Builder
{
    protected $connection;

    public function __construct()
    {
        $this->connection = new DataBase();
    }

    /**
     * @param string $table
     * @param callable $callback
     * @return Blueprint
     */
    public function create(string $table, callable $callback): Blueprint
    {
        $blueprint = new Blueprint($table);
        $callback($blueprint);
        $sql = $blueprint->toSql();
        $this->connection->query($sql);
        return $blueprint;
    }

    /**
     * @param string $table
     * @param string $column
     * @return void
     */
    public function addColumn(string $table, string $column)
    {
        $query = "ALTER TABLE {$table} ADD COLUMN {$column->getDefinition()}";
        $this->connection->query($query);
    }

    /**
     * @param string $table
     * @param string $column
     * @return void
     */
    public function dropColumn(string $table, string $column)
    {
        $query = "ALTER TABLE {$table} DROP COLUMN {$column}";
        $this->connection->query($query);
    }

    /**
     * @param string $table
     * @return void
     */
    public function drop(string $table)
    {
        $sql = "DROP TABLE IF EXISTS $table";
        $this->connection->query($sql);
    }
}