<?php
require_once __DIR__ . '/../System/Helpers/BaseURL.php';
require_once __DIR__ . '/../Modules/User/UserService.php';

use Modules\User\UserService;

// Accept POST or PUT for API
if (!in_array($_SERVER['REQUEST_METHOD'], ['POST', 'PUT'])) {
    http_response_code(405);
    echo json_encode([
        'status' => 'error',
        'message' => 'Method Not Allowed'
    ]);
    exit;
}

// Handle input (FormData via fetch)
$input = $_POST;
if (empty($input)) {
    $input = json_decode(file_get_contents('php://input'), true) ?? [];
}

$service = new UserService();
$result = json_decode($service->httpPut($input['id'] ?? 0, $input), true);

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
    // Update session data
    $_SESSION['_active_session'] = $result['data'] ?? [];

    http_response_code(200);
    echo json_encode([
        'status' => 'success',
        'message' => 'Profile successfully updated',
        'data' => $result['data']
    ]);
    exit;
}

// FAILURE
http_response_code(400);
echo json_encode([
    'status' => 'fail',
    'message' => $result['message'] ?? 'Profile update failed.'
]);
exit;
