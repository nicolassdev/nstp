<?php
// define URL name folder
require_once __DIR__ . '/frontend/boot/BaseURL.php';

$page = $_GET['page'] ?? 'login'; // default page

switch ($page) {

    case 'login':
        require 'frontend/pages/Login/login.php';
        // require 'frontend/pages/Register/register.php';
        break;

    case 'register':
        require 'frontend/pages/Register/register.php';
        break;
    //Dashboard
    case 'dashboard':
        require 'frontend/pages/Dashboard/dashboard.php';
        break;

    case 'profile':
        require 'frontend/pages/Profile/profile.php';
        break;

    case 'report':
        require 'frontend/pages/Report/report.php';
        break;

    case 'enrollment':
        require 'frontend/pages/Enrollment/enrollment.php';
        break;

    case 'logout':
        require 'frontend/components/logout.php';
        exit;

    default:
        require '404.php';
        break;
}
