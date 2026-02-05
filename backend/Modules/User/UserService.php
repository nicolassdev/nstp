<?php

namespace Modules\User;

use System\Helpers\JsonResponse;
use System\Helpers\ApiRouter;
use System\Messages;
use backend\System\Main;
use Exception;
use DateTime;

require_once __DIR__ . '/../../System/Helpers/JsonResponse.php';
require_once __DIR__ . '/../../System/Helpers/ApiRouter.php';
require_once __DIR__ . '/../../System/Main.php';


class UserService extends Main
{

    /**
     * Table name
     *
     * @var string
     */
    protected string $table;

    /**
     * Accepted parameters
     *
     * @var string[]
     */
    protected array $accepted_parameters;

    /**
     * Response column
     *
     * @var string[]
     */
    protected array $response_column;

    protected Messages $Messages;


    /**
     * Accounts constructor.
     */
    public function __construct()
    {


        $this->table = 'user';
        parent::__construct();

        $this->accepted_parameters = [
            'username',
            'password'
        ];


        $this->response_column = [
            'id',
            'full_name',
            'last_name',
            'first_name',
            'sex',
            'contact_number',
            'address',
            'date_created',
            'date_modified',
            'created_by',
            'modified_by',
            'role'
        ];
    }

    public function httpPost(array $payload)
    {
        // Basic Validation
        if (!is_array($payload)) {
            return $this->Messages->jsonErrorInvalidParameters();
        }

        $required_fields = ['username', 'password'];


        foreach ($required_fields as $field) {
            if (!array_key_exists($field, $payload)) {
                return $this->Messages->jsonErrorInvalidParameters();
            }
        }

        $trimmed_payload = $this->trimPayload($payload);

        // Set WHERE clauses
        $this->db->where('username', $trimmed_payload['username']);
        $this->db->where('is_deleted', 0);



        try {
            // Get account information
            // $account = $this->db->getOne($this->table, "*, CONCAT( last_name, ', ', first_name, ' ', middle_name, ' ', COALESCE ( suffix_name, '' ) ) AS full_name");
            $account = $this->db->getOne('user');

            $account['full_name'] = $account['last_name'] . ', ' . $account['first_name'] . ' ' . $account['middle_name'] . ' ' . ($account['suffix_name'] ?? '');


            // Check if there is an error
            if ($this->db->getLastErrno() > 0) {
                // Log error
                $this->Logger->logError($this->db->getLastError());

                return $this->Messages->jsonDatabaseError($this->db->getLastError());
            }

            // Check if account exists
            if (is_null($account)) {
                return $this->Messages->jsonFailResponse('Account Does not Exist');
            }

            // Check if password matches account password
            if (array_key_exists('current_password', $trimmed_payload)) {
                if (!password_verify($trimmed_payload['current_password'], $account['password'])) {
                    return $this->Messages->jsonErrorInvalidCredentials();
                }
            } else {
                // if (!password_verify($trimmed_payload['password'], $account['password'])) {

                //     return $this->Messages->jsonErrorInvalidCredentials();
                // }
                if ($trimmed_payload['password'] !== $account['password']) {

                    return $this->Messages->jsonErrorInvalidCredentials();
                }
            }



            if (!array_key_exists('current_password', $payload)) {
                // Record the last login session
                $this->db->where('id', $account['id']);
                $this->db->update($this->table, ['last_login' => date('Y-m-d h:i:s')]);
            }


            // Generate randomized key unique to session
            // $key = bin2hex(openssl_random_pseudo_bytes(32));

            // Generate user claims based on account information
            $user_claims = [
                'logged_in_id' => $account['id'],
                'logged_in_as' => $account['username'],
                'logged_in_at' => date('Y-m-d h:i A'),
                'role' => $account['role'],
            ];
            // Log info
            // $this->Logger->logInfo("{$_SESSION['_active_session']['username']} logged in.");

            return $this->Messages->jsonSuccessLogin([
                'user' => [
                    'id' => $account['id'],
                    'username' => $account['username'],
                    'full_name' => $account['full_name'],
                    'email_address' => $account['email_address'],
                    'contact_number' => $account['contact_number'],
                    'address' => $account['address'],
                    'role' => $account['role'],

                ]
            ]);
        } catch (Exception $e) {
            // Log exception
            $this->Logger->logCritical($e);

            return $this->Messages->jsonInternalError();
        }
    }

    public function httpGet(array $payload)
    {
        // Basic Validation
        if (!is_array($payload)) {
            return $this->Messages->jsonErrorInvalidParameters();
        } else {

            $trimmed_payload = $this->trimPayload($payload);

            try {
                // Set ORDER BY clause using ID DESC
                $this->db->orderBy('id', 'DESC');

                // Get results
                $results = $this->db->get($this->table, null, "*, CONCAT( last_name, ', ', first_name, ' ', COALESCE ( middle_name, '' ), ' ', COALESCE ( suffix_name, '' ) ) AS full_name");



                // Check if there is an error
                if ($this->db->getLastErrno() > 0) {
                    // Log error
                    $this->Logger->logError($this->db->getLastError(), $trimmed_payload);

                    return $this->Messages->jsonDatabaseError($this->db->getLastError());
                }

                foreach ($results as &$result) {
                    // Initialize permissions container


                    // Check if there is an error
                    if ($this->db->getLastErrno() > 0) {
                        // Log error
                        $this->Logger->logError($this->db->getLastError(), $trimmed_payload);

                        return $this->Messages->jsonDatabaseError($this->db->getLastError());
                    }
                }

                return $api ? $this->buildApiResponse($results, $this->response_column) : $results;
            } catch (Exception $e) {
                // Log exception
                $this->Logger->logCritical($e, $trimmed_payload);

                return $this->Messages->jsonInternalError();
            }
        }
    }

    public function httpPut(array $payload)
    {
        // Basic validation
        if (empty($identity) || !is_numeric($identity) || !array_key_exists('id', $payload)) {
            return $this->Messages->jsonErrorInvalidParameters();
        }

        // Custom accepted parameters (not everything can be edited)
        $accepted_parameters = [
            'id',
            'username',
            'password',
            'new_password',
            'last_name',
            'first_name',
            'middle_name',
            'suffix_name',
            'age',
            'sex',
            'gender',
            'birthdate',
            'contact_number',
            'email_address',
            'address',
            'role',
            'level',
            'allowed_functions',
            'invitation',
            'is_profile',
        ];

        // Remove temporarily as its not needed for now
        unset($payload['invitation']);

        // Validate each property if correct
        foreach ($payload as $key => $value) {
            if (!in_array($key, $accepted_parameters)) {
                return $this->Messages->jsonErrorInvalidParameters($key);
            }
        }

        // Trim payload
        $trimmed_payload = $this->trimPayload($payload);

        // List of required fields must be filled out
        $required_fields = [
            'id',
            'level'
        ];

        // Check if all fields required are filled
        foreach ($required_fields as $field) {
            if (!array_key_exists($field, $trimmed_payload)) {
                return $this->Messages->jsonErrorRequiredFieldsNotFilled();
            }
        }

        // Check if ID matches request ID
        if ($identity != $trimmed_payload['id']) {
            return $this->Messages->jsonErrorInvalidParameters();
        }

        /**
         * is_profile - used to identify if the user is currently requesting from profile page
         * if true then allow the user to update his/her password | else then deny
         * Denied means the request was coming from the private page (settings/usermanagement)
         */
        if (!isset($trimmed_payload['is_profile'])) {
            // Check if user is super user (in short, root)
            if ($_SESSION['_active_session']['is_super_user'] !== 1) {
                // Check if user is one level lower (lower is stronger)
                if ($_SESSION['_active_session']['level'] >= $trimmed_payload['level']) {
                    return $this->Messages->jsonFailResponse('User does not have permission.');
                }
            }
        } else {
            // Unset unnecessary keys
            unset($trimmed_payload['is_profile']);
            unset($trimmed_payload['level']);
        }

        try {
            /**
             * Check if password is included in payload
             *
             * NOTE: You only include password in payload when changing password
             * (for verification). Also, new_password must be included in payload.
             */
            if (array_key_exists('password', $trimmed_payload)) {
                // Check if new password is included in payload
                if (!array_key_exists('new_password', $trimmed_payload)) {
                    return $this->Messages->jsonErrorMissingParameters('new_password');
                }

                // Set WHERE clause
                $this->db->where('id', $trimmed_payload['id']);

                // Get account
                $account = $this->db->getOne($this->table);

                // Check if there is an error
                if ($this->db->getLastErrno() > 0) {
                    // Log error
                    $this->Logger->logError($this->db->getLastError(), $trimmed_payload);

                    return $this->Messages->jsonDatabaseError($this->db->getLastError());
                }

                // Check if there is an account
                if (!$account) {
                    return $this->Messages->jsonFailResponse('Account does not exist.');
                }

                // Verify password if valid
                if (!password_verify($trimmed_payload['password'], $account['password'])) {
                    return $this->Messages->jsonFailResponse('Invalid password.');
                }

                // Convert new password to hash
                $trimmed_payload['password'] = password_hash($trimmed_payload['new_password'], PASSWORD_BCRYPT);

                // Unset new password
                unset($trimmed_payload['new_password']);
            }

            if (array_key_exists('role', $payload) && array_key_exists('level', $payload)) {
                if ($payload['role'] == 0 && $payload['level'] === 0) {
                    $trimmed_payload['is_super_user'] = 1;
                }
            }

            // Set WHERE clause using ID
            $this->db->where('id', $identity);

            // Set modified_by using current active session ID
            $trimmed_payload['modified_by'] = $_SESSION['_active_session']['id'];

            // Set date_modified using current date
            $trimmed_payload['date_modified'] = date('Y-m-d H:i:s');

            // Initialize container
            $allowed_functions = null;

            // Check if there are permissions in payload
            if (array_key_exists('allowed_functions', $trimmed_payload)) {
                // Remove allowed functions from payload temporarily
                $allowed_functions = $trimmed_payload['allowed_functions'];
                unset($trimmed_payload['allowed_functions']);
            }

            //Add payload for sex and remove gender
            if (array_key_exists('gender', $trimmed_payload)) {
                $trimmed_payload['sex'] = $trimmed_payload['gender'];
                unset($trimmed_payload["gender"]);
            }

            // Check if update is successful
            if (!$this->db->update($this->table, $trimmed_payload)) {
                // Log error
                $this->Logger->logError($this->db->getLastError(), $trimmed_payload);

                return $this->Messages->jsonDatabaseError($this->db->getLastError());
            }
            // Log update
            $this->Logger->logInfo("Account entry updated. ID: {$trimmed_payload['id']}");

            return $this->buildApiResponse($trimmed_payload, $this->response_column);
        } catch (Exception $e) {
            // Log exception
            $this->Logger->logCritical($e, $trimmed_payload);

            return $this->Messages->jsonInternalError();
        }
    }


    public function httpDel(array $payload): void
    {
        JsonResponse::success('DELETE payload received', $payload);
    }
}

// -------------------------
// ROUTER
// -------------------------
