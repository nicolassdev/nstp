<?php


namespace backend\System;

use System\Messages;
use ackend\Security\Logger;
use MysqliDb;
use Exception;

/**
 * Class Main
 * @package Core\System
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
     * Configuration class
     *
     * @var Config
     */
    protected Config $Config;



    /**
     * Logger class
     *
     * @var Logger
     */
    protected Logger $Logger;

    /**
     * Main constructor.
     * @param bool $initialize_db
     */
    function __construct($initialize_db = true)
    {
        // Initialize Config instance
        $this->Config = new Config();
        // Initialize Logger instance
        $this->Logger = new Logger();

        // Check if DB must be initialized
        if ($initialize_db) {
            // Create Instance of Query Builder
            $this->db = new MySqliDb($this->Config->dbConnection());
        }

        parent::__construct();
    }

    /**
     * Build API response
     *
     * @param array $data Array of data to build
     * @param array $response_column Array of allowed columns in response
     * @param bool $status Flag for sending success or fail response
     * @return false|string JSON-encoded response or array of values
     */
    function buildApiResponse(array $data = array(), array $response_column = array(), bool $status = true)
    {
        // Check if data is a multi-dimensional array
        if (count($data) === count($data, COUNT_RECURSIVE)) {
            // Not multi-dimensional
            $filtered = array_intersect_key($data, array_flip($response_column));
        } else {
            // Check if array has a normal multi-dimensional indexing
            if (array_key_exists(0, $data)) {
                $filtered = array_map(function ($arr) use ($response_column) {
                    return array_intersect_key($arr, array_flip($response_column));
                }, $data);
            } else {
                // AKO BUDOY!
                $filtered = array_intersect_key($data, array_flip($response_column));
            }
        }

        return $status
            ? $this->Messages->jsonSuccessResponse($filtered)
            : $this->Messages->jsonFailResponse($data);
    }

    /**
     * Trim payload
     *
     * @param mixed $payload Payload to be trimmed
     * @return array|string Trimmed array or string
     */
    public function trimPayload($payload)
    {
        return is_array($payload) ? array_map(array($this, 'trimPayload'), $payload) : (!is_int($payload) && empty($payload) ? null : trim($payload));
    }

    /**
     * Invoke internal class
     *
     * Allows you to cherry-pick the class within this resource,
     * meaning we dont need to initialize all classes in the
     * constructor before running any function.
     *
     * Also, if something's wrong with the class it will not break other classes
     * because they are not connected in the first place.
     *
     * Also, since modules extends this class, it is accessible to any module
     * via $this->invoke().
     *
     * @param null $resource_name Name of resource (null indicates Core module)
     * @param string|null $module_name Name of module within resource to invoke
     * @param string|null $function_name Name of function within module to invoke
     * @param mixed $payload Payload to pass onto function
     * @return mixed Response value from invoked function
     * @throws Exception
     */
    public function invoke($resource_name = null, string $module_name = null, string $function_name = null, $payload = [])
    {
        // Check if module name is null
        if ($module_name === null) {
            throw new Exception('Module name is required!');
        }

        // Check if function name is null
        if ($function_name === null) {
            throw new Exception('Function name is required!');
        }

        // Convert module name to PascalCase
        $class_name = ucfirst($module_name);

        // Check if resource is null
        if ($resource_name === null) {
            // Set Core module class namespace path
            $class = "Core\\Modules\\$class_name";

            // Check if class namespace exists
            if (!class_exists($class)) {
                throw new Exception('Module not found!');
            }

            // Check if function exists within class
            if (!method_exists($class, $function_name)) {
                throw new Exception('Function not found!');
            }
        } else {
            // Convert resource and module name to PascalCase
            $uc_resource_name = ucfirst($resource_name);

            // Set Resource module class namespace path
            $class = "Resources\\$uc_resource_name\\Modules\\$class_name\\API";
        }

        try {
            // INVOKE!
            return call_user_func_array([new $class, $function_name], $payload);
        } catch (Exception $e) {
            // Log invoke error
            file_put_contents(
                __DIR__ . "/../../Logs/invoke_logs.txt",
                date('Y-m-d_H:m:i') . "\n" . $e->getMessage() . PHP_EOL,
                FILE_APPEND | LOCK_EX
            );

            throw new Exception("[InvokeException] " . $e->getMessage(), 0, $e);
        }
    }

    public function migrationCheckpoint(string $checkpoint_name, $value  = null)
    {
        // Check if checkpoint file exists
        $checkpoint_file = __DIR__ . '/../Database/migration_checkpoint.json';
        if (!file_exists($checkpoint_file)) {
            // Create the checkpoint file if it doesn't exist
            file_put_contents($checkpoint_file, json_encode([$checkpoint_name => 0], JSON_PRETTY_PRINT));
            chmod($checkpoint_file, 0666); // Set permissions to allow writing
        }

        // Read the existing checkpoints
        $checkpoints = json_decode(file_get_contents($checkpoint_file), true);
        if (!isset($checkpoints[$checkpoint_name])) {
            // If the checkpoint does not exist, initialize it
            $checkpoints[$checkpoint_name] = 0;
            file_put_contents($checkpoint_file, json_encode($checkpoints, JSON_PRETTY_PRINT));
        }

        if (!is_null($value)) {
            $checkpoints[$checkpoint_name] = $value;
            file_put_contents($checkpoint_file, json_encode($checkpoints, JSON_PRETTY_PRINT));
            return;
        }

        return json_decode(file_get_contents($checkpoint_file), true);
    }
}
