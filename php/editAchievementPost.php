<?php
/**
 * Created by PhpStorm.
 * User: Ray
 * Date: 16/6/5
 * Time: 13:35
 */
session_start();
include "util.php";

$title = $_REQUEST["achievementTitle"];
$content = $_REQUEST["achievementContent"];
$achievementId = $_REQUEST["achievementId"];

$canEdit = false;

$connection = createConnection();
$sql = "SELECT userId FROM achievement WHERE isDeleted=0 AND id=".$achievementId;
$result = $connection -> query($sql);
if($result -> num_rows > 0){
    $row = $result -> fetch_assoc();
    if($_SESSION["userId"] == $row["userId"]){
        $canEdit = true;
    }
}

if($canEdit){
    $sql = "UPDATE achievement SET title='$title',content='$content' WHERE isDeleted=0 AND id=".$achievementId;
    if($connection -> query($sql)){
        echo "success";
    }else{
        echo "编辑文章发生错误";
    }
}
else{
    echo "您没有权限编辑该文章";
}

?>