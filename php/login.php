<?php
/**
 * Created by PhpStorm.
 * User: niqianye
 * Date: 16/5/20
 * Time: 20:56
 */
include "util.php";
session_start();
$userName = $_REQUEST["userNameNavBar"];
$password = $_REQUEST["passwordNavBar"];
$isPassed = 0;

$connection = createConnection();
$sql = "SELECT * FROM user WHERE userName=$userName AND password=$password AND user.isDeleted=0 ";
$result = $connection->query($sql);
if($result -> num_rows > 0){
    $row = $result ->fetch_assoc();

    $isPassed = $row["isPassed"];
    if($isPassed == 1){
        $_SESSION["userId"] = $row["id"];
        $_SESSION["userName"] = $row["userName"];
        $_SESSION["headImage"] = $row["headImage"];
        $_SESSION["name"] = $row["name"];
        $_SESSION["isManager"] = $row["isManager"];
        $_SESSION["isPassed"] = $row["isPassed"];
        echo "success";
    }else{
        echo "您未通过管理员验证,请联系管理员";
    }
}else{
    echo "您输入的帐号密码错误";
}
closeConnection($connection);
?>