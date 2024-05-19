<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$mysqlConnection = new mysqli("localhost", "root", "", "labajax");

if ($mysqlConnection->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $mysqlConnection->connect_error]));
}

$limit = 3;
$offset = isset($_GET['page']) ? intval($_GET['page']) * $limit : 0;

$sql = "SELECT * FROM personal_info LIMIT $limit OFFSET $offset";
$result = $mysqlConnection->query($sql);

if (!$result) {
    die(json_encode(["error" => "Query failed: " . $mysqlConnection->error]));
}

$personal_info = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $personal_info[] = $row;
    }
}

$sql_total = "SELECT COUNT(*) as total FROM personal_info";
$result_total = $mysqlConnection->query($sql_total);

if (!$result_total) {
    die(json_encode(["error" => "Total query failed: " . $mysqlConnection->error]));
}

$total = $result_total->fetch_assoc()['total'];

echo json_encode(['personal_info' => $personal_info, 'total' => $total]);

$mysqlConnection->close();
?>
