<?php


namespace Backend\Security;

/**
 * Class Logger
 * @package Backend\Security
 */
class Logger
{
    /**
     * Log file(s) directory
     *
     * @var string
     */
    private string $logs_directory;

    /**
     * Logger constructor.
     * @param string $logs_directory
     */
    public function __construct($logs_directory = __DIR__ . "/../../Logs/")
    {
        $this->logs_directory = $logs_directory;
    }

    /**
     * System is unusable.
     *
     * @param string $message
     * @param array $context
     * @return Logger
     */
    public function logEmergency($message, $context = array())
    {
        if (!empty($context)) {
            $message = "[EMERGENCY] " . $message . "\n" . print_r($context, true);
        }

        $this->createLog($message, 'emergency_log');

        return $this;
    }

    /**
     * Action must be taken immediately.
     *
     * Example: Entire website down, database unavailable, etc. This should
     * trigger the SMS alerts and wake you up.
     *
     * @param string $message
     * @param array $context
     * @return Logger
     */
    public function logAlert($message, $context = array())
    {
        if (!empty($context)) {
            $message = "[ALERT] " . $message . "\n" . print_r($context, true);
        }

        $this->createLog($message, 'alert_log');

        return $this;
    }

    /**
     * Critical conditions.
     *
     * Example: Application component unavailable, unexpected exception.
     *
     * @param string $message
     * @param array $context
     * @return Logger
     */
    public function logCritical($message, $context = array())
    {
        if (!empty($context)) {
            $message = "[CRITICAL] " . $message . "\n" . print_r($context, true);
        }

        $this->createLog($message, 'critical_log');

        return $this;
    }

    /**
     * Runtime errors that do not require immediate action but should typically
     * be logged and monitored.
     *
     * @param string $message
     * @param array $context
     * @return Logger
     */
    public function logError($message, $context = array())
    {
        if (!empty($context)) {
            $message = "[ERROR] " . $message . "\n" . print_r($context, true);
        }

        $this->createLog($message, 'error_log');

        return $this;
    }

    /**
     * Exceptional occurrences that are not errors.
     *
     * Example: Use of deprecated APIs, poor use of an API, undesirable things
     * that are not necessarily wrong.
     *
     * @param string $message
     * @param array $context
     * @return Logger
     */
    public function logWarning($message, $context = array())
    {
        if (!empty($context)) {
            $message = "[WARNING] " . $message . "\n" . print_r($context, true);
        }

        $this->createLog($message, 'warning_log');

        return $this;
    }

    /**
     * Normal but significant events.
     *
     * @param string $message
     * @param array $context
     * @return Logger
     */
    public function logNotice($message, $context = array())
    {
        if (!empty($context)) {
            $message = "[NOTICE] " . $message . "\n" . print_r($context, true);
        }

        $this->createLog($message, 'notice_log');

        return $this;
    }

    /**
     * Interesting events.
     *
     * Example: User logs in, SQL logs.
     *
     * @param string $message
     * @param array $context
     * @return Logger
     */
    public function logInfo($message, $context = array())
    {
        if (!empty($context)) {
            $message = "[INFO] " . $message . "\n" . print_r($context, true);
        }

        $this->createLog($message, 'info_log');

        return $this;
    }

    /**
     * Detailed debug information from adms.
     *
     * @param string $message
     * @param array $context
     * @return Logger
     */
    public function logADMS($message, $context = array())
    {
        if (!empty($context)) {
            $message = "[DEBUG] " . $message . "\n" . print_r($context, true);
        }

        $this->createLog($message, 'adms_log');

        return $this;
    }


    /**
     * Detailed debug information.
     *
     * @param string $message
     * @param array $context
     * @return Logger
     */
    public function logDebug($message, $context = array())
    {
        if (!empty($context)) {
            $message = "[DEBUG] " . $message . "\n" . print_r($context, true);
        }

        $this->createLog($message, 'debug_log');

        return $this;
    }

    /**
     * Create log entry
     *
     * @param string $message
     * @param string $file_name
     */
    private function createLog($message, $file_name)
    {
        $log_dir = $this->logs_directory . $file_name . '.txt';

        if (file_exists($log_dir)) {
            $file_size = filesize($log_dir);

            if ($file_size > 5_000_000) {
                $backup_dir = $this->logs_directory . "backups/$file_name/";
                if (!is_dir($backup_dir)) {
                    if (!mkdir($backup_dir, 0777, true)) {
                        $message = "BACKUP LOGS ERROR: " . __LINE__ . "\n" . "error: FAILED TO CREATE BACKUP FOLDER $backup_dir";
                        file_put_contents($this->logs_directory . "error_log.txt", $message, FILE_APPEND | LOCK_EX);
                    }
                }

                $backup_file_name = $backup_dir . $file_name . '_' . date('Y-m-d_H.m.i') . '.txt';
                if (!rename($log_dir, $backup_file_name)) {
                    $message = "BACKUP LOGS ERROR: " . __LINE__ . "\n" . "error: FAILED TO BACKUP $file_name";
                    file_put_contents($this->logs_directory . "error_log.txt", $message, FILE_APPEND | LOCK_EX);
                }
            }
        }

        $new_log = "[" . date('Y-m-d_H:m:i') . "]\n" . $message . "\n" . PHP_EOL;
        file_put_contents($log_dir, $new_log, FILE_APPEND | LOCK_EX);
    }
}
