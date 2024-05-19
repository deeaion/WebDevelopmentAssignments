<?php

header("Access-Control-Allow-Origin: *");

$mysqlConnection=new mysqli("localhost","root","","labajax");


if($mysqlConnection->connect_error){
    die("Connection failed: ".$mysqlConnection->connect_error);
} // so . is used to concatenate

$limit=3;
$offset=isset($_GET['page']) ? intval($_GET['page'])*$limit : 0;
$sql="Select * FROM personal_info LIMIT $limit OFFSET $offset";
$result=$mysqlConnection->query($sql);
$personal_info=array();
if($result->num_rows>0){
    while($row=$result->fetch_assoc()){
        $personal_info[]=$row;
    }
}
$sql_total="SELECT COUNT(*) as total FROM personal_info";
$result_total=$mysqlConnection->query($sql_total);
$total=$result_total->fetch_assoc()['total'];
echo json_encode(array('personal_info'=>$personal_info,'total'=>$total));
$mysqlConnection->close();
?>