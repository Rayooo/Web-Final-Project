<?php
/**
 * Created by PhpStorm.
 * User: Ray
 * Date: 16/6/4
 * Time: 18:33
 */
session_start();
include "util.php";
isLogin();
$newsCommentId = $_REQUEST["newsCommentId"];

$canDelete = false;

if($_SESSION["isManager"] == 1){
    $canDelete = true;
}else{
    $connection = createConnection();
    $sql = "SELECT userId FROM newsComment WHERE id=".$newsCommentId;
    $result = $connection -> query($sql);
    if($result -> num_rows > 0){
        $row = $result -> fetch_assoc();
        if($row["userId"] == $_SESSION["userId"]){
            $canDelete = true;
        }
    }
    closeConnection($connection);
}

if($canDelete){
    $connection = createConnection();
    $sql = "UPDATE newsComment SET isDeleted=1 WHERE id=".$newsCommentId;
    if($connection -> query($sql)){
        echo "success";
    }else{
        echo "删除失败";
    }
}
else{
    echo "您没有权限删除";
}
?>