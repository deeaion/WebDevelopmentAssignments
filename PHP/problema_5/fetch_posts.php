<?php
include('../dbUtils.php');
$db = new DbUtils('labphp456');
$result = $db->select('posts', '*', '1');
//adding the person who posted the image
foreach ($result as $key => $value) {
    $id_user = $value['id_user'];
    $username = $db->select('user', 'username', "id = '$id_user'")[0]['username'];
    $result[$key]['username'] = $username;
}
if ($result!=null and sizeof($result) > 0) {
    foreach ($result as $row) {
        echo "<div>";
        echo "<p>" . $row['username'] . "</p>";
        echo "<p>" . $row['description'] . "</p>";
        echo "<img src='" . $row['path'] . "' alt='Post image' width='200'/>";
        echo "</div>";
    }
} else {
    echo "No posts found";
}
$db->closeConnection();
?>
