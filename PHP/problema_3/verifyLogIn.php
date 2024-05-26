<?php
session_start();
require_once '../dbUtils.php';

$DBUtils = new DBUtils('labphp3');
$connection = $DBUtils->getPDO();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the user is a teacher
    $stmt = $connection->prepare('SELECT * FROM teacher WHERE username = :username AND password = :password');
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $_SESSION['username'] = $username;
        $_SESSION['type'] = 'teacher';
        header('Location: profesor.php');
        exit();
    } else {
        // Check if the user is a student
        $stmt = $connection->prepare('SELECT * FROM students WHERE email = :username AND password = :password');
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $_SESSION['username'] = $username;
            $_SESSION['type'] = 'student';
            header('Location: student.php');
            exit();
        } else {
            echo 'Invalid username or password';
        }
    }
}
?>
