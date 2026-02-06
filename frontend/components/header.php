<?php

if (!defined('BASE_URL')) {
    require_once __DIR__ . '/../../404.php';    
}

if (!empty($_SESSION['user_logged_in'])) {
    $user = $_SESSION['_active_session']['user'];
    // Make sure the array structure exists
    $fullName = $_SESSION['_active_session']['user']['full_name'];
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?= $pageTitle ?? 'NSTP System' ?></title>

    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/styles/global.css?v=<?= time() ?>">
    <link rel="icon" type="image/webp" href="<?= BASE_URL ?>/frontend/assets/image/csi.webp">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>


    <?php if (!empty($_SESSION['user_logged_in'])): ?>
        <header class="main-header">
            <div class="logo">NSTP Portal</div>
            <nav class="nav-links">
                <a href="<?= BASE_URL ?>index.php?page=dashboard">Dashboard</a>
                <a href="<?= BASE_URL ?>index.php?page=profile">Profile</a>
                <a href="<?= BASE_URL ?>index.php?page=report">Reports</a>
                <!-- NSTP Enrollment Dropdown -->
                <div class="nav-dropdown">
                    <a href="<?= BASE_URL ?>index.php?page=enrollment" class="dropdown-toggle">
                        NSTP Enrollment ▾
                    </a>

                    <div class="dropdown-menu">
                        <a href="<?= BASE_URL ?>index.php?page=enrollment&status=enroll">
                            Enroll Student
                        </a>
                        <a href="<?= BASE_URL ?>index.php?page=enrollment&status=pending">
                            Pending
                        </a>
                        <a href="<?= BASE_URL ?>index.php?page=enrollment&status=enrolled">
                            Enrolled
                        </a>
                    </div>
                </div>

                <a href="<?= BASE_URL ?>index.php?page=logout">Logout</a>
            </nav>
        </header>
    <?php endif; ?>

    <div class="main-content">