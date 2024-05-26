<?php
require_once 'TrainRoutes.php';
require_once 'compute_route.php';
require_once 'DBUtils.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function GetRequest() {
    $orasPlecare = htmlspecialchars($_POST['departure']);
    $orasSosire = htmlspecialchars($_POST['arrival']);
    $type = htmlspecialchars($_POST['traveling_method']);

    $DBUtils = new DBUtils('labphp');
    $computeRoute = new ComputeRoute($DBUtils, $type);
    $result = $computeRoute->computeRoute($orasPlecare, $orasSosire);
    $DBUtils->closeConnection();

    // Return the result within a specific HTML structure to avoid issues with echo
    return '<div class="results">' . $result . '</div>';
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo GetRequest();
}
?>
