<?php
// session_start();
define('BASE_URL', '/nstp');

$page = $_GET['page'] ?? 'login'; // default page

switch ($page) {

    case 'login':
        require 'frontend/pages/Login/login.php';
        // require 'frontend/pages/Register/register.php';
        break;

    case 'register':
        require 'frontend/pages/Register/register.php';
        break;

    case 'dashboard':
        // protect page
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?page=login');
            exit;
        }
        require 'pages/dashboard.php';
        break;

    case 'home':
        require 'pages/home.php';
        break;

    case 'logout':
        session_destroy();
        header('Location: index.php?page=login');
        exit;

    default:
        require 'pages/404.php';
        break;
}
