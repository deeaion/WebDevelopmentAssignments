<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: logIn.php");
    exit();
}

include('../dbUtils.php');

$viewUsername = isset($_GET['username']) ? $_GET['username'] : $_SESSION['username'];

$dbutils = new DBUtils('labphp456');
$conn = $dbutils->getPDO();
$user = $dbutils->select('user', 'id, username, email', "username = '$viewUsername' OR email = '$viewUsername'");

if (!$user || count($user) === 0) {
    echo "User not found.";
    exit();
}

// Assuming `select` method returns an array of rows, we need to get the first row.
$user = $user[0];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile</title>
    <style>
        header {
            margin-left: 0;
            margin-top: 0;
            height: 40px;
            align-content: center;
            background-color: #333;
        }
        form {
            width: 90%;
            background: bisque;
            padding: 10px;
        }
    </style>
</head>
<body>
<header>
    <button>
        <a href="feed.php">Feed</a>
    </button>
    <form style="display: inline;" action="logOut.php" method="POST">
        <input type="submit" value="Log Out">
    </form>
</header>
<h1>Welcome to <?php echo htmlspecialchars($user['username']); ?>'s profile!</h1>
<p>Here you can see personal information.</p>
<p>Username: <span id="username"><?php echo htmlspecialchars($user['username']); ?></span></p>
<p>Email: <span id="email"><?php echo htmlspecialchars($user['email']); ?></span></p>

<?php if ($viewUsername === $_SESSION['username']): ?>
    <div>
        <fieldset>
            <legend>Add picture</legend>
            <form action="upload.php" method="POST" enctype="multipart/form-data">
                <label for="description">Description:</label>
                <input type="text" id="description" name="description" placeholder="Description"><br>
                <input type="file" id="picture" name="picture" accept="image/*"><br>
                <input type="submit" value="Add"><br>
            </form>
        </fieldset>
    </div>
<?php endif; ?>

<div>
    <h2><?php echo $viewUsername === $_SESSION['username'] ? 'Your' : htmlspecialchars($user['username']) . '\'s'; ?> Posts:</h2>
    <div id="userPosts">
        <!-- Posts will be displayed here -->
        <?php
        $posts = $dbutils->select('posts', 'id, description, path', "id_user = '{$user['id']}'");

        if ($posts && count($posts) > 0) {
            foreach ($posts as $post) {
                echo "<div>";
                echo "<p>" . htmlspecialchars($post['description']) . "</p>";
                echo "<img src='" . htmlspecialchars($post['path']) . "' alt='Post image' width='200'/>";
                if ($viewUsername === $_SESSION['username']) {
                    echo "<form action='delete_post.php' method='POST'>";
                    echo "<input type='hidden' name='post_id' value='" . htmlspecialchars($post['id']) . "'/>";
                    echo "<input type='submit' value='Delete'/>";
                    echo "</form>";
                }
                echo "</div>";
            }
        } else {
            echo "No posts found.";
        }
        ?>
    </div>
</div>
</body>
</html>
