<?php
require_once __DIR__ . '/../System/Helpers/BaseURL.php';
require_once __DIR__ . '/../Modules/User/UserService.php';

use Modules\User\UserService;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'status' => 'error',
        'message' => 'Method not allowed'
    ]);
    exit;
}

// Read JSON OR form-data safely
$input = $_POST;
if (empty($input)) {
    $input = json_decode(file_get_contents('php://input'), true) ?? [];
}

$service = new UserService();
$result = json_decode($service->httpPost($input), true);

if (!is_array($result)) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Unexpected server response'
    ]);
    exit;
}

if (($result['status'] ?? '') === 'success') {
    $_SESSION['user_logged_in'] = true;
    $_SESSION['_active_session'] = $result['data'] ?? [];

    http_response_code(200);
    echo json_encode([
        'status' => 'success',
        'data' => $result['data']
    ]);
    exit;
}

http_response_code(401);
echo json_encode([
    'status' => 'fail',
    'message' => $result['message'] ?? 'Login failed'
]);
exit;
