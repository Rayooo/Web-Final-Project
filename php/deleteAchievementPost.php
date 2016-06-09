<?php
/**
 * Created by PhpStorm.
 * User: niqianye
 * Date: 16/6/2
 * Time: 19:56
 */
session_start();
include "util.php";
isLogin();

$canDelete = false;

$achievementId = $_REQUEST["achievementId"];

$connection = createConnection();

if($_SESSION["isManager"] == 1){
    $canDelete = true;
}else{
    $sql = "SELECT userId FROM achievement WHERE isDeleted=0 AND id=".$achievementId;
    $result = $connection -> query($sql);
    if($result -> num_rows > 0){
        $row = $result -> fetch_assoc();
        if($_SESSION["userId"] == $row["userId"]){
            $canDelete = true;
        }
    }
}

if($canDelete){
    $sql = "UPDATE achievement SET isDeleted=1 WHERE id=".$achievementId;
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