<?php

namespace testFullStackDev\BaseClasses\DataBase\Schema;

class Index
{
    /**
     * @var
     */
    protected $name;
    /**
     * @var array
     */
    protected $columns = [];

    public function __construct(string $name, $columns)
    {
        $this->name = $name;
        $this->columns = $columns;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return array|mixed
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'columns' => $this->columns
        ];
    }
}