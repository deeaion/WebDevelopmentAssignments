<?php
session_start();

// Generare CSRF token dacă nu există deja
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$conn = new mysqli('localhost', 'root', '', 'labphp456');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT name, comment FROM comments WHERE type='APPROVED'");
$approved_comments = $result->fetch_all(MYSQLI_ASSOC);
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Article about Quokka's</title>
    <style>
        body {
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            text-align: center;
        }
        header {
            height: 40px;
            width: 100%;
            background-color: #333;
        }
        img {
            width: 40%;
            height: 40%;
        }
        .comment-form {
            margin: 15px auto;
            padding: 10px;
            background-color: #fff;
            border: 1px solid #ccc;
            width: 60%;
        }
        .comment-form input, .comment-form textarea {
            width: 70%;
            margin-bottom: 10px;
            padding: 8px;
            border: 1px solid #ccc;
        }
        .comment-form button {
            padding: 10px 20px;
            background-color: #333;
            color: #fff;
            border: none;
        }
        .comments-section {
            margin: 20px auto;
            padding: 10px;
            background-color: #8eb663;
            border: 1px solid #d6d4ad;
            width: 50%;
        }
        .comment {
            background-color: #eddada;
            padding: 10px;
            border: 1px solid #ccc;
            margin: 10px auto;
            width: 90%;
        }
    </style>
</head>
<body>
<header></header>
<h1>Quokka's importance</h1>
<div>
    <img src="https://people.com/thmb/ANh_l_7QZyjsj3-33wDVNmULvZ4=/1500x0/filters:no_upscale():max_bytes(150000):strip_icc():focal(999x0:1001x2)/53197051_299728530692890_6746381849213068523_n-2000-49fcbdef916e41308965d20cfb1d02bf.jpg"
         alt="Quokka's" title="Chris Hemsworth surprised at the met with a wild Han Jisung">
</div>
<p><b>Quokka's are the cuttest animals ever</b> and they are very important for the ecosystem.<br>
    I love them so much and I want to protect them.<br></p>
<div>
    <img src="https://i.pinimg.com/736x/0c/54/20/0c5420d3a78e8e46dbbd981f6c691b29.jpg"
         alt="Quokka's" title="They are so full of love">
</div>
<h3> They are so full of love</h3>
<p>Please take care of your environment and protect the quokka's. </p>
<div class="comment-form">
    <h2>Leave a Comment</h2>
    <form action="post_comment.php" method="post">
        <label>
            <input type="text" name="name" placeholder="Your Name" required>
        </label>
        <label>
            <textarea name="comment" placeholder="Your Comment" required></textarea>
        </label>
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
        <button type="submit">Post Comment</button>
    </form>

</div>
<div class="comments-section">
    <h2>Comments</h2>
    <?php foreach ($approved_comments as $comment): ?>
        <div class="comment">
            <p><strong><?php echo htmlspecialchars($comment['name']); ?></strong>:
                <?php echo htmlspecialchars($comment['comment']); ?></p>
        </div>
    <?php endforeach; ?>
</div>
</body>
</html>
