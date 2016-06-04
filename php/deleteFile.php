<?php
/**
 * Created by PhpStorm.
 * User: Ray
 * Date: 16/6/4
 * Time: 20:33
 */
session_start();
include "util.php";
isLogin();

$fileId = $_REQUEST["fileId"];

$canDelete = false;

if($_SESSION["isManager"] == 1){
    $canDelete = true;
}else{
    $connection = createConnection();
    $sql = "SELECT userId FROM file WHERE id=".$fileId;
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
    $sql = "UPDATE file SET isDeleted=1 WHERE id=".$fileId;
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