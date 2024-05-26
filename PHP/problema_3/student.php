<?php
session_start();
require_once '../dBUtils.php';

// Ensure the user is logged in and is a student
if (!isset($_SESSION['username']) || $_SESSION['type'] !== 'student') {
    header('Location: index.php');
    exit();
}

$username = $_SESSION['username'];
$DBUtils = new DBUtils('labphp3');
$connection = $DBUtils->getPDO(); // Assuming this method returns a PDO connection

// Get student ID based on the logged-in username
$stmt = $connection->prepare('SELECT id FROM students WHERE email = :email');
$stmt->bindParam(':email', $username);
$stmt->execute();
$student = $stmt->fetch(PDO::FETCH_ASSOC);

if ($student) {
    $student_id = $student['id'];

    // Get grades for the student
    $stmt = $connection->prepare('
        SELECT subject.name AS subject, grades.grade 
        FROM grades 
        JOIN subject ON grades.id_subject = subject.id 
        WHERE grades.id_student = :student_id
    ');
    $stmt->bindParam(':student_id', $student_id);
    $stmt->execute();
    $grades = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $grades = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Grades</title>
    <style>
        table {
            width: 50%;
            border-collapse: collapse;
            margin: 50px auto;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: center;
            background-color: #4CAF50;
            color: white;
        }
        td {
            text-align: center;
        }
    </style>
</head>
<body>
<h1 style="text-align: center;">Student Grades</h1>
<table>
    <thead>
    <tr>
        <th>Subject</th>
        <th>Grade</th>
    </tr>
    </thead>
    <tbody>
    <?php
    if (count($grades) > 0) {
        foreach ($grades as $grade) {
            echo "<tr><td>{$grade['subject']}</td><td>{$grade['grade']}</td></tr>";
        }
    } else {
        echo "<tr><td colspan='2'>No grades found.</td></tr>";
    }
    ?>
    </tbody>
</table>
<form style="display: inline;" action="logOut.php" method="POST">
    <input type="submit" value="Log Out">
</form>
</body>
</html>
