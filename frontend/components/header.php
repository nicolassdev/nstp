<?php

if (!defined('BASE_URL')) {
    exit('Direct access not allowed');
}

if (!empty($_SESSION['user_logged_in'])) {
    $user = $_SESSION['user_data'];

    // Make sure the array structure exists
    $fullName = $user['user']['full_name'] ?? 'User';

    echo 'Welcome, ' . $fullName;
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
                <a href="<?= BASE_URL ?>index.php?page=enrollment">NSTP Enrollment</a>
                <a href="<?= BASE_URL ?>index.php?page=logout">Logout</a>
            </nav>
        </header>
    <?php endif; ?>

    <div class="main-content">