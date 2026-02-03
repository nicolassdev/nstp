<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>NSTP Login</title>
    <link rel="stylesheet" href="frontend/Login/css/style.css?v=<?php echo time(); ?>">
    <link rel="website icon" type="webp" href="frontend/assets/image/csi.webp">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

    <div class="login-container">
        <div class="login-card">
            <h1>NSTP Portal</h1>
            <p class="subtitle">Sign in to continue</p>


            <form action="backend/Modules/Login/API.php" method="POST">
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
                Having trouble? Contact NSTP Office
            </p>
        </div>
    </div>

</body>


</html>