<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Log In</title>
    <style>
        fieldset {
            width: 200px;
            margin: auto;
        }
        input {
            margin: 5px;
        }
    </style>
</head>
<body>
<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
include('../dbUtils.php');
$username = $_POST['username'];
$password = $_POST['password'];

$dbutils = new DBUtils('labphp456');
$conn = $dbutils->getPDO();

$sql = "SELECT * FROM user WHERE username = :username OR email = :username";
$stmt = $conn->prepare($sql);
$stmt->execute(['username' => $username]);

if ($stmt->rowCount() > 0) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    // Check if the password is correct
    if ($password== $row['password']) {
        $_SESSION['username'] = $row['username'];
        $_SESSION['email'] = $row['email'];
        header("Location: feed.php");
        exit();
    } else {
        echo "Invalid password";
    }
} else {
    echo "No user found with that username";
}
$dbutils->closeConnection();}
?>
<fieldset>
    <form  action="logIn.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <input type="submit" value="Log In">
        <input type="button" value="Sign Up" onclick="window.location.href='signUp.php'">
    </form>
</fieldset>
</body>
</html>
