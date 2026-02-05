<?php
require_once __DIR__ . '/../System/Helpers/BaseURL.php';
require_once __DIR__ . '/../Modules/User/UserService.php';

use Modules\User\UserService;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . BASE_URL . 'index.php?page=login');
    exit;
}

$service = new UserService();

// Decode JSON API response
$result = json_decode($service->httpPut($_POST['id'], $_POST), true);

//  Safety check: invalid JSON
if (!is_array($result)) {
    $_SESSION['user_logged_in'] = false;
    $_SESSION['error'] = 'Unexpected server response.';
    header('Location: ' . BASE_URL . 'index.php?page=dashboard');
    exit;
}

//  SUCCESS
if (($result['status'] ?? '') === 'success') {

    // $getData = json_decode($service->httpGet($result['data']['id'], $_GET), true);

    $_SESSION['user_logged_in'] = true;
    $_SESSION['_active_session'] = $result['data'] ?? [];
    $_SESSION['success'] = 'Profile successful updated.';
    header('Location: ' . BASE_URL . 'index.php?page=profile');
    exit;
}

//  FAILURE — show API error message
$_SESSION['user_logged_in'] = false;
$_SESSION['error'] = $result['message'] ?? 'Profile update failed.';
header('Location: ' . BASE_URL . 'index.php?page=profile');
exit;
