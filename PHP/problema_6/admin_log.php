<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Verificare credentiale
    if ($username === 'admin' && $password === 'securepassword') {
        $_SESSION['admin_logged_in'] = true;
        header('Location: moderate.php');
    } else {
        echo "Invalid credentials.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <style>
        body {
            background-color: #f0f0f0;
            text-align: center;
            padding-top: 50px;
        }
        .login-form {
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ccc;
            width: 300px;
            margin: 0 auto;
        }
        .login-form input {
            width: 100%;
            margin-bottom: 10px;
            padding: 8px;
            border: 1px solid #ccc;
        }
        .login-form button {
            padding: 10px 20px;
            background-color: #333;
            color: #fff;
            border: none;
        }
    </style>
</head>
<body>
<div class="login-form">
    <h2>Admin Login</h2>
    <form action="admin_log.php" method="post">
        <label>
            <input type="text" name="username" placeholder="Username" required>
        </label>
        <label>
            <input type="password" name="password" placeholder="Password" required>
        </label>
        <button type="submit">Login</button>
    </form>
</div>
</body>
</html>
