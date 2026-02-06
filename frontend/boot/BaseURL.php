<?php
//define as file name of folder.
session_start();
define('BASE_URL', '/nstp/');

function requireLogin() {
    if (
        !isset($_SESSION['_active_session']) || 
        empty($_SESSION['_active_session']['user'])
    ) {
        // User is not logged in
        header('Location: ' . BASE_URL . 'index.php?page=login');
        exit();
    }
}

function requireRole($roles = []) {
    // Optional: check if user role is allowed
    $userRole = $_SESSION['_active_session']['user']['role'] ?? null;
    if (!in_array($userRole, $roles)) {
        header('Location: ' . BASE_URL . 'index.php?page=login');
        exit();
    }
}