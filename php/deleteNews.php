<?php
/**
 * Created by PhpStorm.
 * User: Ray
 * Date: 16/6/4
 * Time: 16:35
 */
session_start();
include "util.php";
isManager();

$newsId = $_REQUEST["newsId"];

$connection = createConnection();
$sql = "UPDATE news SET isDeleted=1 WHERE id=".$newsId;

if($connection -> query($sql)){
    echo "success";
}else{
    echo "error";
}

closeConnection($connection);

?>