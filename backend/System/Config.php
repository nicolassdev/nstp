<?php

namespace Backend\System;

/**
 * Class Config
 * @package Core\System
 */
class Config
{
    /**
     * Secret Key
     *
     * Used to sign the JWT means that the secret is a
     * symmetric key that is known by both the sender
     * and the receiver.
     *
     * @var string
     */
    protected string $secret_key;

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
            // 'db' => 'p8_core_db',
            // 'db' => 'p8_core_yashano_db',
            'db' => 'p8_core_yashano_v2',
            // An optional table prefix which will added to the table name when running Query Builder queries.
            'prefix' => 'tbl_',
            // The character set used in communicating with the database.
            'charset' => 'utf8',
            // Port used by the MySQL server
            'port' => 3306,
        ];

        // PHPMailer Configuration
        $this->email_config = [
            // Set the SMTP server to send through
            'Host' => 'mail.ph',
            // Enable implicit TLS encryption
            'SMTPSecure' => 'ssl',
            // Enable SMTP authentication
            'SMTPAuth' => true,
            // SMTP username
            'Username' => 'noreply@gmail.com',
            // SMTP password
            'Password' => '_=IJv}XMKr&&',
            // SMTP port
            'Port' => 465,
        ];

        /**
         * This is authentication key
         *
         * NOTE: Any modification to the JWT will result in verification failure!
         */
        $this->secret_key = 'kt}et(q{8>c8J~}=mJ;@D<#jQYPVxJZz2Pv"eJ8#n"';
    }

    /**
     * secretKey
     *
     * @return string
     */
    public function secretKey(): string
    {
        return $this->secret_key;
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

    /**
     * emailConfiguration
     *
     * @return array|string[]
     */
    public function emailConfiguration(): array
    {
        return $this->email_config;
    }
}
