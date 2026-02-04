<?php
session_start();

$pageTitle = 'NSTP Login';

// include header (2 levels up → nstp/)
require_once __DIR__ . '/../../components/header.php';
?>

<div class="login-container">
    <div class="login-card">
        <h1>NSTP Portal</h1>
        <p class="subtitle">Sign in to continue</p>

        <form action="<?= BASE_URL ?>/backend/Modules/Login/API.php" method="POST">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" required placeholder="Enter your username">
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required placeholder="Enter your password">
            </div>

            <button type="submit" class="btn-login">Login</button>
        </form>

        <p class="help-text">
            Does student not registered? <a href="index.php?page=register">Register</a>
        </p>
    </div>
</div>

<?php
require_once __DIR__ . '/../../components/footer.php';
?>
