<?php

namespace Modules\Login;

use System\Helpers\JsonResponse;
use System\Helpers\ApiRouter;
use System\Messages;
use backend\System\Main;
use Exception;
use DateTime;

require_once __DIR__ . '/../../System/Helpers/JsonResponse.php';
require_once __DIR__ . '/../../System/Helpers/ApiRouter.php';
require_once __DIR__ . '/../../System/Main.php';


class LoginService extends Main
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
            if(array_key_exists('current_password', $trimmed_payload)){
                if (!password_verify($trimmed_payload['current_password'], $account['password'])) {
                    return $this->Messages->jsonErrorInvalidCredentials();
                }
            }else{
                // if (!password_verify($trimmed_payload['password'], $account['password'])) {
                
                //     return $this->Messages->jsonErrorInvalidCredentials();
                // }
                if ($trimmed_payload['password'] !== $account['password']) {
                
                    return $this->Messages->jsonErrorInvalidCredentials();
                }
            }
            


            if(!array_key_exists('current_password', $payload)){
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

    public function httpGet(array $payload): void
    {
        JsonResponse::success('GET payload received', $payload);
    }

    public function httpPut(array $payload): void
    {
        JsonResponse::success('PUT payload received', $payload);
    }

    public function httpDel(array $payload): void
    {
        JsonResponse::success('DELETE payload received', $payload);
    }
}

// -------------------------
// ROUTER
// -------------------------
 
