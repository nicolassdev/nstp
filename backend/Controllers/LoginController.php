<?php
require_once __DIR__ . '/../System/Helpers/BaseURL.php';
require_once __DIR__ . '/../Modules/Login/LoginService.php';

use Modules\Login\LoginService;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . BASE_URL . 'index.php?page=login');
    exit;
}

$service = new LoginService();

// Decode JSON API response
$result = json_decode($service->httpPost($_POST), true);

//  Safety check: invalid JSON
if (!is_array($result)) {
    $_SESSION['error'] = 'Unexpected server response.';
    header('Location: ' . BASE_URL . 'index.php?page=login');
    exit;
}

//  SUCCESS
if (($result['status'] ?? '') === 'success') {
    $_SESSION['user_logged_in'] = true; 
    $_SESSION['user_data'] = $result['data'] ?? [];
    $_SESSION['success'] = 'Login successful. Please login.';
    header('Location: ' . BASE_URL . 'index.php?page=dashboard');
    exit;
}

//  FAILURE — show API error message
$_SESSION['error'] = $result['message'] ?? 'Login failed.';
header('Location: ' . BASE_URL . 'index.php?page=login');
exit;
