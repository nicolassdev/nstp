<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Page Not Found | NSTP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        body {
            margin: 0;
            height: 100vh;
            background: linear-gradient(135deg, #2e7d32, #66bb6a);
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', sans-serif;
            color: #333;
        }

        .card {
            background: #fff;
            padding: 40px;
            border-radius: 14px;
            text-align: center;
            max-width: 420px;
            width: 90%;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }

        .error-code {
            font-size: 80px;
            font-weight: bold;
            color: #2e7d32;
            margin: 0;
        }

        h2 {
            margin: 10px 0;
        }

        p {
            color: #666;
            font-size: 15px;
        }

        .btn-group {
            margin-top: 25px;
        }

        a {
            text-decoration: none;
            padding: 12px 22px;
            border-radius: 8px;
            margin: 5px;
            display: inline-block;
            font-size: 14px;
        }

        .btn-primary {
            background: #2e7d32;
            color: #fff;
        }

        .btn-secondary {
            border: 1px solid #2e7d32;
            color: #2e7d32;
        }

        a:hover {
            opacity: 0.9;
        }

        .footer-text {
            margin-top: 20px;
            font-size: 13px;
            color: #777;
        }
    </style>
</head>

<body>

    <div class="card">
        <p class="error-code">404</p>
        <h2>Oops! Page not found</h2>
        <p>
            The page you’re looking for doesn’t exist or may have been moved.
        </p>

        <div class="btn-group">
            <a href="index.php?page=login" class="btn-primary">Go to Login</a>
            <a href="index.php?page=home" class="btn-secondary">Back to Home</a>
        </div>

        <div class="footer-text">
            NSTP Management System
        </div>
    </div>

</body>

</html>