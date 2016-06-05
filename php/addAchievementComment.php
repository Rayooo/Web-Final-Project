<?php
/**
 * Created by PhpStorm.
 * User: Ray
 * Date: 16/6/5
 * Time: 14:53
 */
session_start();
include "util.php";
isLogin();

$userId = $_SESSION["userId"];
$achievementId = $_REQUEST["achievementId"];
$achievementComment = $_REQUEST["achievementComment"];
$createTime = getSQLDateTime();

$connection = createConnection();
$sql = "INSERT INTO achievementcomment (content, userId, achievementId, createTime)".
    " VALUES ('$achievementComment',$userId,$achievementId,'$createTime')";

if($connection -> query($sql)){
    echo "success";
}else{
    echo "error";
}
closeConnection($connection);


?>