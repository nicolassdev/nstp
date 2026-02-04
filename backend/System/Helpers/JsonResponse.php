<?php

namespace System\Helpers;

class JsonResponse
{
    public static function send(
        bool $status,
        string $message = '',
        array $payload = [],
        int $httpCode = 200
    ): void {
        http_response_code($httpCode);
        header('Content-Type: application/json; charset=utf-8');

        echo json_encode([
            'status'  => $status,
            'message' => $message,
            'payload' => $payload
        ]);

        exit;
    }

    public static function error(
        string $message,
        int $httpCode = 400,
        array $payload = []
    ): void {
        self::send(false, $message, $payload, $httpCode);
    }

    public static function success(
        string $message,
        array $payload = [],
        int $httpCode = 200
    ): void {
        self::send(true, $message, $payload, $httpCode);
    }
}
