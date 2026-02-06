<?php

if (!defined('BASE_URL')) {
    require_once __DIR__ . '/../../404.php';
}

if (!empty($_SESSION['user_logged_in'])) {
    $user = $_SESSION['_active_session']['user'];
    // Make sure the array structure exists
    $fullName = $_SESSION['_active_session']['user']['full_name'];
}


$currentPage = $_GET['page'] ?? 'dashboard';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?= $pageTitle ?? 'NSTP System' ?></title>

    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/styles/global.css?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/styles/enrollment.css?v=<?= time() ?>">
    <link rel="icon" type="image/webp" href="<?= BASE_URL ?>/frontend/assets/image/csi.webp">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>


    <?php if (!empty($_SESSION['user_logged_in'])): ?>
        <header class="topbar">
            <div class="topbar-title">
                NSTP Management System
            </div>

            <div class="topbar-actions">
                <span class="user-name">
                    👋 <?= htmlspecialchars($fullName) ?>
                </span>
                <a href="<?= BASE_URL ?>index.php?page=logout" class="btn-logout">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </header>

        <div class="layout">
            <aside class="sidebar">
                <div class="sidebar-logo">
                    <i class="fas fa-graduation-cap"></i>
                    <span>NSTP Portal</span>
                </div>

                <nav class="sidebar-nav">
                    <!-- Dashboard -->
                    <a href="<?= BASE_URL ?>index.php?page=dashboard"
                        class="<?= $currentPage === 'dashboard' ? 'active' : '' ?>">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>

                    <!-- Profile -->
                    <a href="<?= BASE_URL ?>index.php?page=profile"
                        class="<?= $currentPage === 'profile' ? 'active' : '' ?>">
                        <i class="fas fa-user"></i>
                        <span>Profile</span>
                    </a>

                    <!-- NSTP Enrollment -->
                    <?php
                    $enrollmentActive = in_array($currentPage, [
                        'enroll-student',
                        'enrollment-pending',
                        'enrollment-enrolled'
                    ]);
                    ?>
                    <div class="sidebar-dropdown ">
                        <a
                            class="sidebar-link dropdown-toggle">
                            <i class="fas fa-users"></i>
                            <span>NSTP Enrollment</span>
                            <i class="fas fa-chevron-down dropdown-icon"></i>
                        </a>

                        <div class="dropdown-content" style="<?= $enrollmentActive ? 'display:flex;' : '' ?>">
                            <a href="<?= BASE_URL ?>index.php?page=enroll-student"
                                class="<?= $currentPage === 'enroll-student' ? 'active' : '' ?>">
                                Enroll Student
                            </a>

                            <a href="<?= BASE_URL ?>index.php?page=enrollment-pending"
                                class="<?= $currentPage === 'enrollment-pending' ? 'active' : '' ?>">
                                Pending
                            </a>

                            <a href="<?= BASE_URL ?>index.php?page=enrollment-enrolled"
                                class="<?= $currentPage === 'enrollment-enrolled' ? 'active' : '' ?>">
                                Enrolled
                            </a>
                        </div>
                    </div>

                    <!-- Report -->
                    <a href="<?= BASE_URL ?>index.php?page=report"
                        class="<?= $currentPage === 'report' ? 'active' : '' ?>">
                        <i class="fas fa-home"></i>
                        <span>Reports</span>
                    </a>
                </nav>
            </aside>

            <main class="main-content">
            <?php endif; ?>


            <div class="main-content">