<?php
/**
 * Created by PhpStorm.
 * User: Ray
 * Date: 16/6/3
 * Time: 21:32
 */
session_start();
include "util.php";
isManager();

$userId = $_REQUEST["userId"];

$connection = createConnection();
$sql = "UPDATE user SET isPassed=1 WHERE id=$userId";
if($connection->query($sql) == true){
    echo "success";
}else{
    echo "error";
}

?>