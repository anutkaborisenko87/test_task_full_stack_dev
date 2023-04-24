<?php

namespace testFullStackDev\BaseClasses;

use PDO;
class Config
{
    /**
     * @return array
     */
    public static function databaseConfig(): array
    {
        return [
            'host' => config('db_host'),
            'port' => config('db_port'),
            'database' => config('db_name'),
            'username' => config('db_user'),
            'password' => config('db_pass'),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'options' => [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ],
        ];
    }
}