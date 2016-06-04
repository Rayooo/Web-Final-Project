<?php
/**
 * Created by PhpStorm.
 * User: Ray
 * Date: 16/6/4
 * Time: 14:17
 */
session_start();
include "util.php";
isManager();

$userId = $_REQUEST["userId"];
if($userId == $_SESSION["userId"]){
    die();
}

$connection = createConnection();

try{
    $connection -> begin_transaction();
    $sql = "UPDATE user SET isDeleted=1 WHERE id=".$userId;
    if($connection -> query($sql)){
        $sql = "UPDATE achievement SET isDeleted=1 WHERE userId="+$userId;
        $connection -> query($sql);

        $sql = "UPDATE newscomment SET isDeleted=1 WHERE userId="+$userId;
        $connection -> query($sql);

        $sql = "UPDATE achievementcomment SET isDeleted=1 WHERE userId="+$userId;
        $connection -> query($sql);

        $sql = "UPDATE file SET isDeleted=1 WHERE userId="+$userId;
        $connection -> query($sql);

        $sql = "UPDATE photo SET isDeleted=1 WHERE userId="+$userId;
        $connection -> query($sql);

        $connection->commit();

        echo "success";

    }
    else{
        $connection -> rollback();
        echo "error";
    }
}catch (Exception $e){
    $connection -> rollback();
    echo "error";
}

closeConnection($connection);

?>