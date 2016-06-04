<?php
/**
 * Created by PhpStorm.
 * User: Ray
 * Date: 16/6/4
 * Time: 16:39
 */
session_start();
include "util.php";
$choice = $_REQUEST["choice"];
$currentNewsId = $_REQUEST["currentNewsId"];
$returnNewsId = null;

$connection = createConnection();
$sql = "SELECT id FROM news WHERE isDeleted = 0";
$result = $connection -> query($sql);

if($result -> num_rows > 0){
    $n = 0;
    $row = $result -> fetch_all(MYSQLI_ASSOC);
    while ($n < mysqli_num_rows($result)){
        if($row[$n]["id"] == $currentNewsId){
            if($choice == "previous"){
                if($n - 1 < 0){
                    echo "noNews";
                }else{
                    echo $row[$n - 1]["id"];
                }
                break;
            }else if($choice == "next"){

                if($n + 1 >= mysqli_num_rows($result)){
                    echo "noNews";
                }else{
                    echo $row[$n + 1]["id"];
                }
                break;
            }
        }
        else{
            $n++;
        }
    }
}



?>