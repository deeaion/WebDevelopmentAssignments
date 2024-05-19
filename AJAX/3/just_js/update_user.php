<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$mysqlConnection = new mysqli("localhost", "root", "", "labajax");

if ($mysqlConnection->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $mysqlConnection->connect_error]));
}

$data = json_decode(file_get_contents('php://input'), true);
$id = intval($data['id']);
$nume = $mysqlConnection->real_escape_string($data['nume']);
$prenume = $mysqlConnection->real_escape_string($data['prenume']);
$telefon = $mysqlConnection->real_escape_string($data['telefon']);
$email = $mysqlConnection->real_escape_string($data['email']);

$sql = "UPDATE personal_info SET nume='$nume', prenume='$prenume', telefon='$telefon', email='$email' WHERE id=$id";
$result = $mysqlConnection->query($sql);

$response = [];
if ($result) {
    $response["success"] = true;
    // Poți returna și datele actualizate pentru a reflecta schimbările pe client
    $response["nume"] = $nume;
    $response["prenume"] = $prenume;
    $response["telefon"] = $telefon;
    $response["email"] = $email;
} else {
    $response["error"] = "Error updating record: " . $mysqlConnection->error;
}

$mysqlConnection->close();

echo json_encode($response);
?>
