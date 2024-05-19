<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "labajax";

// Crearea conexiunii
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificarea conexiunii
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Preluarea valorilor din cererea AJAX și escaparea lor pentru a preveni SQL injection
$manufacturer = $conn->real_escape_string($_GET['manufacturer']);
$processor = $conn->real_escape_string($_GET['processor']);
$memory = $conn->real_escape_string($_GET['memory']);
$hdd = $conn->real_escape_string($_GET['hdd']);
$graphics = $conn->real_escape_string($_GET['graphics']);

// Construirea interogării SQL
$sql = "SELECT * FROM notebooks WHERE 1=1";

if (!empty($manufacturer)) {
    $sql .= " AND manufacturer='$manufacturer'";
}
if (!empty($processor)) {
    $sql .= " AND processor LIKE '%$processor%'";
}
if (!empty($memory)) {
    $sql .= " AND memory='$memory'";
}
if (!empty($hdd)) {
    $sql .= " AND hdd='$hdd'";
}
if (!empty($graphics)) {
    $sql .= " AND graphics LIKE '%$graphics%'";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>Producător</th>
                <th>Procesor</th>
                <th>Memorie</th>
                <th>Capacitate HDD</th>
                <th>Placa Video</th>
            </tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["manufacturer"] . "</td>
                <td>" . $row["processor"] . "</td>
                <td>" . $row["memory"] . "</td>
                <td>" . $row["hdd"] . "</td>
                <td>" . $row["graphics"] . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "0 rezultate";
}

$conn->close();
?>
