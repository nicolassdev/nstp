<?php

namespace System\Helpers;

use System\Helpers\JsonResponse;

class ApiRouter
{
    /**
     * Routes HTTP requests to class methods automatically
     *
     * @param object $apiInstance Instance of the API class
     */
    public static function route(object $apiInstance)
    {
        // Determine HTTP method
        $method = $_SERVER['REQUEST_METHOD'];

        // Get payload based on HTTP method
        $payload = match ($method) {
            'POST'   => $_POST,
            'GET'    => $_GET,
            'PUT', 'DELETE' => json_decode(file_get_contents('php://input'), true) ?? [],
            default  => null
        };

        // Validate payload
        if (!is_array($payload)) {
            $response = JsonResponse::error('Invalid payload format', 422);
            self::send($response);
        }

        // Call the appropriate method and capture response
        $response = match ($method) {
            'POST'    => $apiInstance->httpPost($payload),
            'GET'     => $apiInstance->httpGet($payload),
            'PUT'     => $apiInstance->httpPut($payload),
            'DELETE'  => $apiInstance->httpDel($payload),
            default   => JsonResponse::error('Method not allowed', 405),
        };

        self::send($response);
    }

    /**
     * Send JSON response with correct headers
     *
     * @param string|null $response
     */
    protected static function send(?string $response): void
    {
        header('Content-Type: application/json');
        echo $response ?? JsonResponse::error('Empty response from API', 500);
        exit;
    }
}
