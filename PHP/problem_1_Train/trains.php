<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Train Routes</title>
    <style>
        form {
            width: 300px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid black;
            border-radius: 10px;
        }
        input[type="text"] {
            width: 100%;
            margin-bottom: 10px;
        }
        input[type="radio"] {
            margin-right: 10px;
        }
        fieldset {
            margin-bottom: 10px;
        }
        input[type="submit"] {
            width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>
<form method="post">
    <label for="departure">Departure Location:</label>
    <input type="text" id="departure" name="departure" required> <br>
    <label for="arrival">Arrival Location:</label>
    <input type="text" id="arrival" name="arrival" required>
    <fieldset>
        <legend>Traveling Method:</legend>
        <label for="directOnly"> Direct Routes: </label>
        <input type="radio" id="directOnly" name="traveling_method" value="directOnly"> <br>
        <label for="indirect"> Indirect Routes: </label>
        <input type="radio" id="indirect" name="traveling_method" value="indirect"> <br>
        <label for="all"> All Routes: </label>
        <input type="radio" id="all" name="traveling_method" value="all"> <br>
    </fieldset>
    <input type="submit" value="Search">
</form>
<div>
    <?php
    require_once 'TrainRoutes.php';
    require_once 'compute_route.php';
    require_once '../dbUtils.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $orasPlecare = $_POST['departure'];
        $orasSosire = $_POST['arrival'];
        $type = $_POST['traveling_method'];

        $DBUtils = new DBUtils('labphp');

        $computeRoute = new ComputeRoute($DBUtils, $type);
        $result = $computeRoute -> computeRoute($orasPlecare, $orasSosire);

    // Output the result within a specific HTML structure to avoid issues with echo
    echo '<div class="results">';
    echo $result;
    echo '</div>';

    $DBUtils->closeConnection();
    }
    ?>
</div>


</body>
</html>
