<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$mysqlConnection = new mysqli("localhost", "root", "", "labajax");

if ($mysqlConnection->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $mysqlConnection->connect_error]));
}
$sql="SELECT email FROM personal_info";
$result = $mysqlConnection->query($sql);
$itemList=array();
while($row = $result->fetch_assoc()) {
    $itemList[] = $row;
}
$mysqlConnection->close();
echo json_encode($itemList);
?>