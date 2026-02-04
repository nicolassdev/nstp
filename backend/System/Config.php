<?php

namespace System;

/**
 * Class Config
 * @package Core\System
 */
class Config
{

    /**
     * Database Connection String
     *
     * @var string[]
     */
    protected array $conn;

    /**
     * Email Sender configuration
     *
     * @var string[]
     */
    protected array $email_config;

    /**
     * Config constructor.
     */
    public function __construct()
    {
        // Database Configuration
        $this->conn = [
            // The hostname of your database server. Often this is ‘localhost’.
            'host' => 'localhost',
            // The username used to connect to the database.
            'username' => 'root',
            // The password used to connect to the database.
            'password' => '',
            // The name of the database you want to connect to.
            'db' => 'nstp_management_db',
            // An optional table prefix which will added to the table name when running Query Builder queries.
            'prefix' => 'tbl_',
            // The character set used in communicating with the database.
            'charset' => 'utf8',
            // Port used by the MySQL server
            'port' => 3306,
        ];
    }


    /**
     * dbConnection
     *
     * @return string[]
     */
    public function dbConnection(): array
    {
        return $this->conn;
    }
}
