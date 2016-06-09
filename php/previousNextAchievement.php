<?php
/**
 * Created by PhpStorm.
 * User: niqianye
 * Date: 16/5/27
 * Time: 21:00
 */
session_start();
include "util.php";
$choice = $_REQUEST["choice"];
$currentAchievementId = $_REQUEST["currentAchievementId"];
$returnAchievementId = null;

$connection = createConnection();
$sql = "SELECT id FROM achievement WHERE isDeleted = 0";
$result = $connection -> query($sql);

if($result -> num_rows > 0){
    $n = 0;
    $row = $result -> fetch_all(MYSQLI_ASSOC);
    while ($n < mysqli_num_rows($result)){
        if($row[$n]["id"] == $currentAchievementId){
            if($choice == "previous"){
                if($n - 1 < 0){
                    echo "noAchievement";
                }else{
                    echo $row[$n - 1]["id"];
                }
                break;
            }else if($choice == "next"){

                if($n + 1 >= mysqli_num_rows($result)){
                    echo "noAchievement";
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