<?php
// define URL name folder
require_once __DIR__ . '/frontend/boot/BaseURL.php';

$page = $_GET['page'] ?? 'login'; // default page

// Pages that require login
$protectedPages = ['dashboard', 'profile', 'report', 'enrollment'];

if (in_array($page, $protectedPages)) {
    requireLogin(); // check session
}
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

    case 'enroll-student':
        require 'frontend/pages/Enrollment/pages/enroll-student.php';
        break;

    case 'enrollment-pending':
        require 'frontend/pages/Enrollment/pages/enrollment-pending.php';
        break;

    case 'enrollment-enrolled':
        require 'frontend/pages/Enrollment/pages/enrollment-enrolled.php';
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
