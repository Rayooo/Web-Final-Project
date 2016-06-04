<?php
/**
 * Created by PhpStorm.
 * User: Ray
 * Date: 16/6/4
 * Time: 15:03
 */
session_start();
include "util.php";
isManager();

$newsContent = $_REQUEST["newsContent"];
$newsTitle = $_REQUEST["newsTitle"];
$userId = $_REQUEST["userId"];
$createTime = getSQLDateTime();

$connection = createConnection();
$sql = "INSERT INTO news (userId, title, content, createTime) ".
    "VALUES ($userId,'$newsTitle','$newsContent','$createTime')";
if($connection -> query($sql)){
    echo "success";
}else{
    echo "error";
}

?>