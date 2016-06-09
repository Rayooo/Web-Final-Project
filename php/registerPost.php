<?php
/**
 * Created by PhpStorm.
 * User: niqianye
 * Date: 16/5/25
 * Time: 20:56
 */
include "util.php";
$userName = $_REQUEST["userName"];
$password = $_REQUEST["password"];
$name = $_REQUEST["name"];
$isManager = $_REQUEST["isManager"];

$isError = false;
$message = "服务器异常";

$createTime = getSQLDateTime();

$sql = "INSERT INTO user (userName, password, name, createTime, isManager, headImage)".
    "VALUES('$userName','$password','$name','$createTime',$isManager,'../image/headImage.png')";
$connection = createConnection();
if($connection -> query($sql) == true){
    $isError = false;
}
else{
    $isError = true;
    $message = "存在相同的用户名,请修改用户名后重新提交";
}
closeConnection($connection);

if(!$isError){
    echo "success";
}else{
    echo $message;
}



?>