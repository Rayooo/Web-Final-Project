<?php
/**
 * Created by PhpStorm.
 * User: Ray
 * Date: 16/6/3
 * Time: 13:23
 */


function createConnection(){
    return mysqli_connect("localhost:8889","root","root","WebFinalProject");
}

function closeConnection($connection){
    $connection->close();
}

//以下三个是在前端判断是否登录,是否是管理员,是否是用户
function confirmationLogin(){
    if(!isset($_SESSION["userName"])){
        $url = 'index.php';
        echo "<script>location.href='$url'</script>";
    }
}

function confirmationManager(){
    if(!isset($_SESSION["userName"]) || !isset($_SESSION["isManager"]) || $_SESSION["isManager"] != 1){
        $url = 'index.php';
        echo "<script>location.href='$url'</script>";
    }
}

function confirmationUser(){
    if(!isset($_SESSION["userName"]) || !isset($_SESSION["isManager"]) ||  $_SESSION["isManager"] != 0){
        $url = 'index.php';
        echo "<script>location.href='$url'</script>";
    }
}
//以下三个在后端判断
function isLogin(){
    if( !isset($_SESSION["isPassed"]) || $_SESSION["isPassed"] == 0){
        die();
    }
}

function isManager(){
    if (!isset($_SESSION["isPassed"]) || !isset($_SESSION["isManager"]) || $_SESSION["isPassed"] != 1 || $_SESSION["isManager"] != 1){
        die();
    }
}

function isUser(){
    if (!isset($_SESSION["isPassed"]) || !isset($_SESSION["isManager"]) || $_SESSION["isPassed"] != 1 || $_SESSION["isManager"] != 0){
        die();
    }
}

function getSQLDateTime(){
    date_default_timezone_set("PRC");
    return date("Y-m-d H:i:s");
}

function redirect($url){
    echo "<script>location.href='$url'</script>";
}



?>