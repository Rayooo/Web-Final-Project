<?php
/**
 * Created by PhpStorm.
 * User: Ray
 * Date: 16/6/5
 * Time: 12:57
 */
session_start();
include "util.php";
isUser();

$achievementTitle = $_REQUEST["achievementTitle"];
$achievementContent = $_REQUEST["achievementContent"];
$userId = $_REQUEST["userId"];

$createTime = getSQLDateTime();
$connection = createConnection();
$sql = "INSERT INTO achievement (userId, title, content, createTime) ".
    "VALUES ($userId,'$achievementTitle','$achievementContent','$createTime')";
if($connection -> query($sql)){
    echo "success";
}else{
    echo "error";
}
?>