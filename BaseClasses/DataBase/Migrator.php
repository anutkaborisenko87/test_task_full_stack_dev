<?php

namespace testFullStackDev\BaseClasses\DataBase;


use testFullStackDev\BaseClasses\Migration;

class Migrator extends DataBase
{
    /**
     * @var array
     */
    protected $migrations = [];


    /**
     * @param Migration $migration
     * @return void
     */
    public function addMigration(Migration $migration): void
    {
        $this->migrations[] = $migration;
    }

    /**
     * @return void
     */
    public function migrate(): void
    {
        foreach ($this->migrations as $migration) {
            $migration->up();
        }
    }

    /**
     * @return void
     */
    public function rollback(): void
    {
        foreach (array_reverse($this->migrations) as $migration) {
            $migration->down();
        }
    }
}