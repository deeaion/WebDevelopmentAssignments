<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$mysqlConnection = new mysqli("localhost", "root", "", "labajax");

if ($mysqlConnection->connect_error) {
    echo json_encode(["error" => "Connection failed: " . $mysqlConnection->connect_error]);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);
$field1 = $mysqlConnection->real_escape_string($data['type']);
$field2 = $mysqlConnection->real_escape_string($data['value']);

$sql = "SELECT * FROM personal_info WHERE $field1 = '$field2'";
$result = $mysqlConnection->query($sql);

$response = [];
if ($result && $result->num_rows > 0) {
    $response['data'] = $result->fetch_assoc();
} else {
    $response['error'] = "No records found";
}

$mysqlConnection->close();
echo json_encode($response);
?>
