<?php
/**
 * Created by PhpStorm.
 * User: niqianye
 * Date: 16/6/2
 * Time: 14:30
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