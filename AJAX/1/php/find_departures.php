<?php
header("Access-Control-Allow-Origin: *");
$mysqli = new mysqli("localhost", "root", "", "labajax");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$sql = "SELECT DISTINCT Departure FROM trainroutes";
$result = $mysqli->query($sql);

$departures = array();
while ($row = $result->fetch_assoc()) {
    $departures[] = $row['Departure'];
}

echo json_encode($departures); // I SEND IT AS JSON
$mysqli->close();
?>
