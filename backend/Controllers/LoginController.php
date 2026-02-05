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
$result = json_decode($service->httpPost($_POST), true);

//  Safety check: invalid JSON
if (!is_array($result)) {
    $_SESSION['user_logged_in'] = false;
    $_SESSION['error'] = 'Unexpected server response.';
    header('Location: ' . BASE_URL . 'index.php?page=login');
    exit;
}

//  SUCCESS
if (($result['status'] ?? '') === 'success') {
    $_SESSION['user_logged_in'] = true;
    $_SESSION['_active_session'] = $result['data'] ?? [];

    $userInfo = $result['data']['user'] ?? [];
    $_SESSION['success'] = 'Login successful. Please login.';
    header('Location: ' . BASE_URL . 'index.php?page=dashboard');
    exit;
}

//  FAILURE — show API error message
$_SESSION['user_logged_in'] = false;
$_SESSION['error'] = $result['message'] ?? 'Login failed.';
header('Location: ' . BASE_URL . 'index.php?page=login');
exit;
