<?php


namespace System;


/**
 * Class Messages
 * @package Core\System
 */
class Messages
{
    /**
     * ---------------------------------------
     * Fail Responses
     * ---------------------------------------
     */

    /**
     * @return false|string
     */
    public function jsonErrorCSRFDetected()
    {
        return json_encode([
            'status' => 'fail',
            'message' => 'Unable to proceed: CSRF detected.'
        ]);
    }

    /**
     * @param string $props
     * @return false|string
     */
    public function jsonErrorInvalidParameters($props = "variable not set")
    {
        return json_encode([
            'status' => 'fail',
            'message' => "Invalid Payload Properties: $props"
        ]);
    }

    /**
     * @param $payload_id
     * @param $id
     * @return false|string
     */
    public function jsonErrorIdentificationMismatch($payload_id, $id)
    {
        return json_encode([
            'status' => 'fail',
            'message' => "Identification Mismatch payload: $payload_id | id : $id"
        ]);
    }

    /**
     * @param null $props
     * @return false|string
     */
    public function jsonErrorMissingParameters($props)
    {
        return json_encode([
            'status' => 'fail',
            'message' => "Object Property is missing : $props"
        ]);
    }

    /**
     * @param $field
     * @param $data_type
     * @return false|string
     */
    public function jsonErrorInvalidParamValues($field, $data_type)
    {
        return json_encode([
            'status' => 'fail',
            'message' => "$field must be a valid $data_type value."
        ]);
    }

    /**
     * @return false|string
     */
    public function jsonErrorRequiredFieldsNotFilled()
    {
        return json_encode([
            'status' => 'fail',
            'message' => 'Required fields was not filled.'
        ]);
    }

    /**
     * @return false|string
     */
    public function jsonErrorInvalidCredentials()
    {
        return json_encode([
            'status' => 'fail',
            'message' => 'Login failed: Invalid credentials.'
        ]);
    }


    /**
     * @param $URI
     * @return false|string
     */
    public function jsonErrorModuleNotExist($URI)
    {
        return json_encode([
            'status' => 'fail',
            'message' => 'Requested module not found.',
            'data' => [
                'uri' => $URI
            ]
        ]);
    }

    /**
     * @return false|string
     */
    public function jsonErrorRequestMethodNotServed()
    {
        return json_encode([
            'status' => 'fail',
            'message' => 'Request Method is not allowed.',
            'data' => [
                'method' => $_SERVER["REQUEST_METHOD"]
            ]
        ]);
    }

    /**
     * @param $URI
     * @return false|string
     */
    public function jsonErrorResourceNotFound($URI)
    {
        return json_encode([
            'status' => 'fail',
            'message' => 'Invalid Resources URI.',
            'data' => [
                'uri' => $URI
            ]
        ]);
    }

    /**
     * @param $URI
     * @return false|string
     */
    public function jsonErrorMethodNotServed($URI)
    {
        return json_encode([
            'status' => 'fail',
            'message' => 'Request Method not served.',
            'data' => [
                'method' => $_SERVER["REQUEST_METHOD"],
                'uri' => $URI,
            ]
        ]);
    }

    /**
     * @return false|string
     */
    public function jsonErrorInvalidToken()
    {
        return json_encode([
            'status' => 'fail',
            'message' => 'Verification failed: invalid or expired token.'
        ]);
    }

    /**
     * @param $duplicate_value
     * @return false|string
     */
    public function jsonErrorDataAlreadyExists($duplicate_value)
    {
        return json_encode([
            'status' => 'fail',
            'message' => 'Data already exists in the database.',
            'data' => [
                'duplicate_value' => $duplicate_value
            ]
        ]);
    }

    /**
     * @return false|string
     */
    public function jsonFailedPing()
    {
        return json_encode([
            'status' => 'fail',
            'message' => 'Unable to connect to database.'
        ]);
    }

    /**
     * @return false|string
     */
    public function jsonInternalError()
    {
        return json_encode([
            'status' => 'fail',
            'message' => 'Internal Server Error: Please try again.'
        ]);
    }

    /**
     * @param $message
     * @return false|string
     */
    public function jsonDatabaseError($message = 'Please try again.')
    {
        return json_encode([
            'status' => 'fail',
            'message' => "Database Error: $message"
        ]);
    }

    /**
     * -------------------------------------
     * Success Responses
     * -------------------------------------
     */

    /**
     * @return false|string
     */
    public function jsonSuccessLogout()
    {
        return json_encode([
            'status' => 'success',
            'message' => 'Logout successful.',
        ]);
    }

    /**
     * @param $user_claims
     * @return false|string
     */
    public function jsonSuccessLogin($user_claims)
    {
        return json_encode([
            'status' => 'success',
            'message' => 'Login successful.',
            'data' => $user_claims,
        ]);
    }

    /**
     * @param $data
     * @return false|string
     */
    public function jsonSuccessResponse($data)
    {
        return json_encode([
            'status' => 'success',
            'data' => $data,
            'method' => $_SERVER["REQUEST_METHOD"]
        ], JSON_NUMERIC_CHECK);
    }

    /**
     * @param $data
     * @return false|string
     */
    public function jsonFailResponse($data)
    {
        return json_encode([
            'status' => 'fail',
            'message' => $data,
            'method' => $_SERVER["REQUEST_METHOD"]
        ], JSON_NUMERIC_CHECK);
    }

    /**
     * @param $module
     * @return false|string
     */
    public function jsonNoRowsUpdated($module)
    {
        return json_encode([
            'status' => 'fail',
            'message' => "ID from $module module does not exist."
        ]);
    }

    /**
     * @return false|string
     */
    public function jsonConnectionClosed()
    {
        return json_encode([
            'status' => 'success',
            'message' => 'Connection closed.'
        ]);
    }

    /**
     * @return false|string
     */
    public function jsonPing()
    {
        return json_encode([
            'status' => 'success',
            'message' => 'PONG!'
        ]);
    }
}
