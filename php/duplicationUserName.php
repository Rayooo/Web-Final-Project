<?php
/**
 * Created by PhpStorm.
 * User: Ray
 * Date: 16/6/3
 * Time: 20:17
 */
include "util.php";
$userName = $_REQUEST["userName"];
$connection = createConnection();
$sql = "SELECT count(id) FROM user WHERE userName='$userName'";
$result = $connection->query($sql);
if($result->num_rows > 0){
    $row = $result->fetch_assoc();
    $count = $row["count(id)"];
    if($count == 1){
        echo "error";
    }else{
        echo "success";
    }
}
closeConnection($connection);
?>