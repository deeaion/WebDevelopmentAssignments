<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['csrf_token']) && hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        $name = trim($_POST['name']);
        $comment = trim($_POST['comment']);

        // Validarea datelor
        if (!empty($name) && !empty($comment) && strlen($name) <= 100 && strlen($comment) <= 500) {
            // Evitarea SQL injection
            $conn = new mysqli('localhost', 'root', '', 'labphp456');
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $stmt = $conn->prepare("INSERT INTO comments (name, comment) VALUES (?, ?)");
            if ($stmt === false) {
                die("Prepare failed: " . $conn->error);
            }

            $stmt->bind_param('ss', $name, $comment);
            $stmt->execute();
            $stmt->close();
            $conn->close();
            echo "Comment submitted for moderation.";
        } else {
            echo "Invalid input.";
        }
    } else {
        echo "Invalid CSRF token.";
    }
} else {
    echo "Invalid request method.";
}
?>
