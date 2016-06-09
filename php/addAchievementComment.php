<?php
/**
 * Created by PhpStorm.
 * User: niqianye
 * Date: 16/5/28
 * Time: 21:56
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