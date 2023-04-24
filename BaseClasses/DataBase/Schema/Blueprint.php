<?php

namespace testFullStackDev\BaseClasses\DataBase\Schema;

class Blueprint
{
    /**
     * @var string
     */
    protected $table;
    /**
     * @var array
     */
    protected $columns = [];

    public function __construct(string $table)
    {
        $this->table = $table;
    }

    /**
     * @param string $column
     * @return Column
     */
    public function increments(string $column): Column
    {
        $column = new Column($column, 'INT', ['AUTO_INCREMENT' => true, 'PRIMARY KEY' => true]);
        $this->columns[] = $column;
        return $column;
    }

    /**
     * @param string $column
     * @return Column
     */
    public function integer(string $column): Column
    {
        $column = new Column($column, 'INT');
        $this->columns[] = $column;
        return $column;
    }

    /**
     * @param string $column
     * @param $length
     * @return Column
     */
    public function string(string $column, $length = 191): Column
    {
        $column = new Column($column, "VARCHAR($length)");
        $this->columns[] = $column;
        return $column;
    }

    /**
     * @param string $column
     * @return Column
     */
    public function text(string $column): Column
    {
        $column = new Column($column, 'TEXT');
        $this->columns[] = $column;
        return $column;
    }

    /**
     * @param string $column
     * @return Column
     */
    public function datetime(string $column): Column
    {
        $column = new Column($column, 'DATETIME');
        $this->columns[] = $column;
        return $column;
    }

    /**
     * @param string $column
     * @return Column
     */
    public function boolean(string $column): Column
    {
        $column = new Column($column, 'TINYINT(1)');
        $this->columns[] = $column;
        return $column;
    }

    /**
     * @param string $column
     * @return Column
     */
    public function timestamp(string $column): Column
    {
        $column = new Column($column, 'TIMESTAMP');
        $this->columns[] = $column;
        return $column;
    }

    /**
     * @return void
     */
    public function timestamps()
    {
        $this->timestamp('created_at');
        $this->timestamp('updated_at');
    }


    /**
     * @return string
     */
    public function toSql(): string
    {
        $sql = "CREATE TABLE IF NOT EXISTS  {$this->table}(";
        $definitions = [];
        foreach ($this->columns as $column) {
            $definitions[] = $column->getDefinition();
        }
        $sql .= implode(',', $definitions);
        $sql .= ")";
        return $sql;
    }

}