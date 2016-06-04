<?php
/**
 * Created by PhpStorm.
 * User: Ray
 * Date: 16/6/4
 * Time: 16:29
 */
session_start();
include "util.php";
isManager();

$title = $_REQUEST["newsTitle"];
$content = $_REQUEST["newsContent"];
$newsId = $_REQUEST["newsId"];

$connection = createConnection();
$sql = "UPDATE news SET title='$title',content='$content' WHERE isDeleted=0 AND id=".$newsId;
if($connection -> query($sql)){
    echo "success";
}else{
    echo "error";
}

closeConnection($connection);
?>