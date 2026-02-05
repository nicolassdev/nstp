<?php

namespace Modules\Registration;

use System\Helpers\JsonResponse;
use System\Helpers\ApiRouter;
use System\Messages;
use backend\System\Main;
use Exception;
use DateTime;

require_once __DIR__ . '/../../System/Helpers/JsonResponse.php';
require_once __DIR__ . '/../../System/Helpers/ApiRouter.php';
require_once __DIR__ . '/../../System/Main.php';


class RegistrationService extends Main
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


        $this->table = 'student';
        parent::__construct();

        $this->accepted_parameters = [
            'id',
            'last_name',
            'first_name',
            'middle_name',
            'email_address',
            'address',
            'birthdate',
            'contact_number',
            'sex',
            'age',
            'photo',
            'date_created',
        ];

        $this->response_column = [
            'id',
            'last_name',
            'first_name',
            'middle_name',
            'email_address',
            'address',
            'birthdate',
            'contact_number',
            'sex',
            'age',
            'photo',
            'date_created',
        ];
    }

    public function httpPost(array $payload)
    {
        // Basic Validation
        if (!is_array($payload)) {
            return $this->Messages->jsonErrorInvalidParameters();
        }else {
            // Validate each property if correct


    
                $trimmed_payload = $this->trimPayload($payload);
        
        
                // Fix: Convert sex to integer (1 or 0) for tinyint
                if (array_key_exists('sex', $trimmed_payload)) {
                    $trimmed_payload['sex'] = (int) ($trimmed_payload['sex'] == "1" || $trimmed_payload['sex'] == 1);
                } else {
                    $trimmed_payload['sex'] = 0; // Default value
                }
        
                 if (array_key_exists('middle_name', $trimmed_payload)) {
                     $trimmed_payload['middle_name'] = $trimmed_payload['middle_name'];
                    if($trimmed_payload["middle_name"] === null){
                        unset($trimmed_payload["middle_name"]);
                    }
                 }


                /* Check if new Youth Information Exist */
                if (array_key_exists('first_name', $payload) && array_key_exists('last_name', $payload)) {
                    $this->db->where('first_name', $payload['first_name']);
                    $this->db->where('last_name', $payload['last_name']);
                    // $this->db->where('deleted_at', 0);
                    $is_duplicated = $this->db->get($this->table);
                    if (count($is_duplicated) > 0) {
                        return $this->Messages->jsonFailResponse('Student Already exists.');
                    }
                }
        
                // Required fields validation (uncommented and fixed)
                $required_fields = [
                    'last_name',
                    'first_name',
                    'middle_name',
                    'email_address',
                    'address',
                    'birthdate',
                    'contact_number',
                    'sex'
                ];
    
                // Insert using $this (not $this->db)
        
                $this->db->insert($this->table, $trimmed_payload);
                // return [ 'success' => true,  'data' => $payload];
        
                return $this->buildApiResponse($trimmed_payload, $this->response_column);
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

 
