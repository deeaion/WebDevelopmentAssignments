<?php
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_log.php');
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'labphp456');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comment_id = $_POST['comment_id'];
    $action = $_POST['action'];

    if ($action === 'approve') {
        $stmt = $conn->prepare("UPDATE comments SET type='APPROVED' WHERE id = ?");
    } elseif ($action === 'reject') {
        $stmt = $conn->prepare("DELETE FROM comments WHERE id = ?");
    }

    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param('i', $comment_id);
    $stmt->execute();
    $stmt->close();
}

$result = $conn->query("SELECT id, name, comment FROM comments WHERE type='WAITING'");
$comments = $result->fetch_all(MYSQLI_ASSOC);
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Moderate Comments</title>
    <style>
        body {
            background-color: #f0f0f0;
            text-align: center;
            padding-top: 50px;
        }
        .comment {
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ccc;
            margin: 20px auto;
            width: 50%;
        }
        .comment form {
            display: inline;
        }
    </style>
</head>
<body>
<h2>Moderate Comments</h2>
<?php foreach ($comments as $comment): ?>
    <div class="comment">
        <p><strong><?php echo htmlspecialchars($comment['name']); ?></strong>: <?php echo htmlspecialchars($comment['comment']); ?></p>
        <form action="moderate.php" method="post">
            <input type="hidden" name="comment_id" value="<?php echo $comment['id']; ?>">
            <button type="submit" name="action" value="approve">Approve</button>
            <button type="submit" name="action" value="reject">Reject</button>
        </form>
    </div>
<?php endforeach; ?>
</body>
</html>
