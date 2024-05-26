<?php
include('../dbUtils.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $description = $_POST['description'];
    $username = $_SESSION['username'];

    // Create user directory if it doesn't exist
    $user_dir = "images/" . $username;
    if (!is_dir($user_dir)) {
        mkdir($user_dir, 0777, true);
    }

    // Handle file upload
    $target_file = $user_dir . "/" . basename($_FILES["picture"]["name"]);
    $dbutils = new DBUtils('labphp456');
    $conn = $dbutils->getPDO();
    $id_user = $dbutils->select('user', 'id', "username = '$username'")[0]['id'];
    echo $id_user;
    if (move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file)) {
        // Insert the post into the database
        $stmt = $conn->prepare("INSERT INTO posts (id_user, description, path) VALUES ('$id_user', '$description', '$target_file')");

        if ($stmt->execute()) {
            header("Location: feed.php");
            exit();
        } else {
            echo "Error: Could not save post to database.";
        }
    } else {
        echo "Error: Could not upload file.";
    }
}
?>
