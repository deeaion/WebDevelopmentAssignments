<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <style>
        fieldset {
            width: 200px;
            margin: auto;
        }
        input {
            margin: 5px;
        }
        form {
            width: 90%;
            background: bisque;
            padding: 10px;
        }
    </style>
</head>
<body>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include('../dbUtils.php');
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $dbutils = new DBUtils('labphp456');
    $conn = $dbutils->getPDO();
    if ($password != $confirm_password) {
        echo "<p style='color: red'>Passwords do not match!</p>";
    } else {

        $sql = "INSERT INTO user (username, email, password, first_name, last_name) VALUES ('$username', '$email', '$password', '$firstName', '$lastName')";

        if ($conn->query($sql) === TRUE) {
            header("Location: logIn.php");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    $conn->close();
}
?>
<fieldset>
    <legend>Sign Up</legend>
    <form action="signUp.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <br>
        <label for="password"> Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <label for="confirm_password"> Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required>
        <br>
        <label for="firstName"> First Name:</label><input type="text" id="firstName" name="firstName" required>
        <br>
        <label for="lastName"> Last Name:</label><input type="text" id="lastName" name="lastName" required>
        <br>
        <input type="submit" value="Sign Up">
        <br>
        <input type="button" value="Log In" onclick="window.location.href='logIn.php'">
    </form>
</fieldset>
</body>
</html>
