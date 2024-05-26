<?php
//verific daca un user e logat
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: logIn.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Feed</title>
</head>
<body>
<header>
    <button id="feed">
        <a href="feed.php">Feed</a>
    </button>
    <button id="profile">
        <a href="profil.php">Profile</a>
    </button>
    <label for="usernameToSearch">Find friends</label>
    <input type="text" id="usernameToSearch" name="usernameToSearch">
    <button id="search">Search for friends</button>
    <form style="display: inline;" action="logOut.php" method="POST">
        <input type="submit" value="Log Out">
    </form>
</header>
<h1>Feed</h1>
<p>Here you can see all the posts of your friends.</p>
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
<div id="posts">

    <?php
    include('fetch_posts.php');
    ?>
</div>
</body>
</html>
