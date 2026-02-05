<?php
session_start();

require_once __DIR__ . '/../System/Helpers/BaseURL.php';
require_once __DIR__ . '/../Modules/Registration/RegistrationService.php';

use Modules\Registration\RegistrationService;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . BASE_URL . 'index.php?page=register');
    exit;
}

$service = new RegistrationService();

// Decode JSON API response
$result = json_decode($service->httpPost($_POST), true);

//  Safety check: invalid JSON
if (!is_array($result)) {
    $_SESSION['error'] = 'Unexpected server response.';
    header('Location: ' . BASE_URL . 'index.php?page=register');
    exit;
}

//  SUCCESS
if (($result['status'] ?? '') === 'success') {
    $_SESSION['success'] = 'Registration successful. Please login.';
    header('Location: ' . BASE_URL . 'index.php?page=login');
    exit;
}

//  FAILURE — show API error message
$_SESSION['error'] = $result['message'] ?? 'Registration failed.';
header('Location: ' . BASE_URL . 'index.php?page=register');
exit;
