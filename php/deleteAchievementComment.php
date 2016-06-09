<?php
/**
 * Created by PhpStorm.
 * User: niqianye
 * Date: 16/5/27
 * Time: 22:30
 */
session_start();
include "util.php";
isLogin();

$canDelete = false;

$achievementCommentId = $_REQUEST["achievementCommentId"];
$achievementAuthor = $_REQUEST["achievementAuthor"];

$connection = createConnection();

//管理员有权限删除所有,发布该成果的用户有权限删除所有
if($_SESSION["isManager"] == 1 || $achievementAuthor == $_SESSION["userId"]){
    $canDelete = true;
}else{
    $sql = "SELECT userId FROM achievementComment WHERE id=".$achievementCommentId;
    $result = $connection -> query($sql);
    if($result -> num_rows > 0){
        $row = $result -> fetch_assoc();
        if($_SESSION["userId"] == $row["userId"]){
            $canDelete = true;
        }
    }
}


if($canDelete){
    $sql = "UPDATE achievementComment SET isDeleted=1 WHERE id=".$achievementCommentId;
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