<?php

namespace backend\System;

use System\Messages;
use backend\Security\Logger;
use MysqliDb;
use Exception;
use System\Config;

require_once __DIR__ . '/MysqliDb.php';
require_once __DIR__ . '/Messages.php';
require_once __DIR__ . '/Config.php';
// require_once __DIR__ . './../Security/Logger.php';

/**
 * Class Main
 * @package backend\System
 */
class Main extends MysqliDb
{
    /**
     * MySQL DB class
     *
     * @var MysqliDb
     */
    public MysqliDb $db;

    /**
     * Messages helper
     *
     * @var Messages
     */
    protected Messages $Messages;

    /**
     * Logger class
     *
     * @var Logger
     */
    protected Logger $Logger;

    /**
     * Config class
     *
     * @var Config
     */
    protected Config $Config;

    /**
     * Main constructor.
     * @param bool $initialize_db
     */
    public function __construct(bool $initialize_db = true)
    {
        // Initialize Messages instance
        $this->Messages = new Messages();

        // Initialize Config instance
        $this->Config = new Config();

        // Initialize Logger instance
        // $this->Logger = new Logger();

        // Initialize DB
        if ($initialize_db) {
            // Create Instance of Query Builder
            $this->db = new MySqliDb($this->Config->dbConnection());
        }

        // parent::__construct();

        parent::__construct();
    }

    /**
     * Build API response
     *
     * @param array $data Array of data to build
     * @param array $response_column Allowed columns in response
     * @param bool $status Flag for sending success or fail response
     * @return string JSON response
     */
    public function buildApiResponse(array $data = [], array $response_column = [], bool $status = true): string
    {
        // Handle multi-dimensional array
        if (count($data) === count($data, COUNT_RECURSIVE)) {
            // Single record
            $filtered = array_intersect_key($data, array_flip($response_column));
        } else {
            if (array_key_exists(0, $data)) {
                // Multiple records
                $filtered = array_map(fn($arr) => array_intersect_key($arr, array_flip($response_column)), $data);
            } else {
                $filtered = array_intersect_key($data, array_flip($response_column));
            }
        }

        return $status
            ? $this->Messages->jsonSuccessResponse($filtered)
            : $this->Messages->jsonFailResponse($data);
    }

    /**
     * Recursively trim payload
     *
     * @param mixed $payload
     * @return array|string|null
     */
    public function trimPayload($payload)
    {
        if (is_array($payload)) {
            return array_map([$this, 'trimPayload'], $payload);
        }

        if (is_int($payload)) {
            return $payload;
        }

        return empty($payload) ? null : trim($payload);
    }
}
