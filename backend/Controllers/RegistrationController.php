<?php
require_once __DIR__ . '/../System/Helpers/BaseURL.php';
require_once __DIR__ . '/../Modules/Registration/RegistrationService.php';

use Modules\Registration\RegistrationService;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'status' => 'error',
        'message' => 'Method Not Allowed'
    ]);
    exit;
}

// Use POST or JSON input
$input = $_POST;
if (empty($input)) {
    $input = json_decode(file_get_contents('php://input'), true) ?? [];
}

$service = new RegistrationService();
$result = json_decode($service->httpPost($input), true);

if (!is_array($result)) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Unexpected server response.'
    ]);
    exit;
}

// SUCCESS
if (($result['status'] ?? '') === 'success') {
    http_response_code(200);
    echo json_encode([
        'status' => 'success',
        'message' => 'Registration successful.',
        'data' => $result['data'] ?? null
    ]);
    exit;
}

// FAILURE
http_response_code(400);
echo json_encode([
    'status' => 'fail',
    'message' => $result['message'] ?? 'Registration failed.'
]);
exit;
