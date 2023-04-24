<?php

namespace testFullStackDev\BaseClasses;
use testFullStackDev\BaseClasses\DataBase\Schema\Builder;
use testFullStackDev\BaseClasses\DataBase\Connection;

abstract class Migration
{
    /**
     * @var Connection
     */
    protected $connection;
    /**
     * @var Builder
     */
    protected $schema;

    public function __construct()
    {
        $this->connection = new Connection();
        $this->schema = new Builder();
    }

    /**
     * @return mixed
     */
    public abstract function up();

    /**
     * @return mixed
     */
    public abstract function down();

}