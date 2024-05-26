<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: logIn.php");
    exit();
}

include('../dbUtils.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['post_id'])) {
    $post_id = $_POST['post_id'];

    $dbutils = new DBUtils('labphp456');
    $conn = $dbutils->getPDO();

    // Fetch the post to get the file path
    $query = "SELECT path FROM posts WHERE id = :post_id AND id_user = (SELECT id FROM user WHERE username = :username)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
    $stmt->bindParam(':username', $_SESSION['username'], PDO::PARAM_STR);
    $stmt->execute();
    $post = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($post) {
        // Delete the post from the database
        $query = "DELETE FROM posts WHERE id = :post_id AND id_user = (SELECT id FROM user WHERE username = :username)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $stmt->bindParam(':username', $_SESSION['username'], PDO::PARAM_STR);
        if ($stmt->execute()) {
            // Delete the image file from the filesystem
            if (file_exists($post['path'])) {
                unlink($post['path']);
            }
            header("Location: profile.php");
            exit();
        } else {
            echo "Error: Could not delete post from database.";
        }
    } else {
        echo "Error: Post not found or you do not have permission to delete this post.";
    }
} else {
    echo "Invalid request.";
}
?>
