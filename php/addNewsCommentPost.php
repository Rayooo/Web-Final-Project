<?php
/**
 * Created by PhpStorm.
 * User: Ray
 * Date: 16/6/4
 * Time: 18:19
 */
session_start();
include "util.php";
isLogin();

$userId = $_SESSION["userId"];
$newsId = $_REQUEST["newsId"];
$newsComment = $_REQUEST["newsComment"];
$createTime = getSQLDateTime();

$connection = createConnection();
$sql = "INSERT INTO newsComment (content, userId, newsId, createTime)".
    " VALUES ('$newsComment',$userId,$newsId,'$createTime')";

if($connection -> query($sql)){
    echo "success";
}else{
    echo "error";
}
closeConnection($connection);


?>