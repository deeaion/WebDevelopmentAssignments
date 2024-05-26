<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Problema 3</title>
    <style>
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 20%;
            background: cadetblue;
            padding: 20px;
            border-radius: 10px;
        }
        input {
            margin: 10px;
        }

    </style>
</head>
<body>
<h1>Problema 3</h1>
<form method="post" action="verifyLogIn.php">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>
    <br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br>
    <input type="submit" id="submit" name="submit" value="Submit">
</form>
</body>
</html>
