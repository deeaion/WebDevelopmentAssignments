<?php
header("Access-Control-Allow-Origin: *");

$mysqlConnection=new mysqli("localhost","root","","labajax");


if($mysqlConnection->connect_error){
    die("Connection failed: ".$mysqlConnection->connect_error);
} // so . is used to concatenate
$sql="SELECT Arrival from trainroutes WHERE Departure= ?";

$stmt= $mysqlConnection->prepare($sql);
$stmt->bind_param("s",$_GET['departure']);  //s is for string
$stmt->execute();
$stmt->bind_result($result);
$arrivals= array(); // empty array
while($stmt->fetch()){
    $arrivals[]=$result;
}
echo json_encode($arrivals); //trimit iarasi json
$mysqlConnection->close();
?>


