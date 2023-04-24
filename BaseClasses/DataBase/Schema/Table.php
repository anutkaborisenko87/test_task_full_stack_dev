<?php

namespace testFullStackDev\BaseClasses\DataBase\Schema;

class Table
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var array
     */
    private $columns = [];

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @param string $name
     * @return Column
     */
    public function increments(string $name): Column
    {
        return $this->addColumn($name, 'int', ['primary_key' => true, 'auto_increment' => true]);
    }

    /**
     * @param string $name
     * @param int $length
     * @return Column
     */
    public function string(string $name, int $length = 255): Column
    {
        return $this->addColumn($name, 'varchar', ['length' => $length]);
    }

    /**
     * @param string $name
     * @return Column
     */
    public function integer(string $name): Column
    {
        return $this->addColumn($name, 'int');
    }

    /**
     * @param string $name
     * @return Column
     */
    public function text(string $name): Column
    {
        return $this->addColumn($name, 'text');
    }

    /**
     * @param string $name
     * @return Column
     */
    public function timestamp(string $name): Column
    {
        return $this->addColumn($name, 'timestamp');
    }

    /**
     * @param string $name
     * @return Column
     */
    public function dateTime(string $name): Column
    {
        return $this->addColumn($name, 'datetime');
    }

    /**
     * @param string $name
     * @return Column
     */
    public function float(string $name): Column
    {
        return $this->addColumn($name, 'float');
    }

    /**
     * @param string $name
     * @return Column
     */
    public function double(string $name): Column
    {
        return $this->addColumn($name, 'double');
    }

    /**
     * @param string $name
     * @param int $precision
     * @param int $scale
     * @return Column
     */
    public function decimal(string $name, int $precision = 8, int $scale = 2): Column
    {
        return $this->addColumn($name, 'decimal', ['precision' => $precision, 'scale' => $scale]);
    }

    /**
     * @param string $name
     * @return Column
     */
    public function boolean(string $name): Column
    {
        return $this->addColumn($name, 'tinyint', ['length' => 1]);
    }

    /**
     * @param string $name
     * @param string $type
     * @param array $options
     * @return Column
     */
    public function addColumn(string $name, string $type, array $options = []): Column
    {
        $column = new Column($name, $type, $options);
        $this->columns[] = $column;
        return $column;
    }

    /**
     * @return array
     */
    public function getColumns(): array
    {
        return $this->columns;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param $columns
     * @return $this
     */
    public function primary($columns): Table
    {
        if (!is_array($columns)) {
            $columns = [$columns];
        }
        foreach ($this->columns as $column) {
            if (in_array($column->getName(), $columns)) {
                $column->setPrimaryKey(true);
            }
        }
        return $this;
    }

    /**
     * @param $columns
     * @return $this
     */
    public function unique($columns): Table
    {
        if (!is_array($columns)) {
            $columns = [$columns];
        }
        foreach ($this->columns as $column) {
            if (in_array($column->getName(), $columns)) {
                $column->setUnique(true);
            }
        }
        return $this;
    }

    /**
     * @param $columns
     * @param string|null $name
     * @return Index
     */
    public function index($columns, ?string $name): Index
    {
        if (!is_array($columns)) {
            $columns = [$columns];
        }
        $index = new Index($name, $columns);
        $this->columns[] = $index;
        return $index;
    }
}