<?php
/**
 * Created by PhpStorm.
 * User: Ray
 * Date: 16/6/4
 * Time: 19:14
 */
session_start();
include "util.php";

$photoId = $_REQUEST["photoId"];

$canDelete = false;

if($_SESSION["isManager"] == 1){
    $canDelete = true;
}else{
    $connection = createConnection();
    $sql = "SELECT userId FROM photo WHERE id=".$photoId;
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
    $sql = "UPDATE photo SET isDeleted=1 WHERE id=".$photoId;
    if($connection -> query($sql)){
        echo "success";
    }else{
        echo "删除失败";
    }
    closeConnection($connection);
}else{
    echo "您没有权限删除";
}




?>