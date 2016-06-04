<?php
/**
 * Created by PhpStorm.
 * User: Ray
 * Date: 16/6/4
 * Time: 20:25
 */

session_start();
include "util.php";
isLogin();

$description = $_REQUEST["description"];
$createTime = getSQLDateTime();
$userId = $_SESSION["userId"];

$isError = true;

if(!empty($_FILES["uploadFile"]["tmp_name"])){
    $originalFileName = $_FILES["uploadFile"]["name"];
    $uploadFileType = explode(".", $_FILES["uploadFile"]["name"]);
    $now = date("YmdHis");
    $randNum = rand(10000,99999);
    $newName = $now.$randNum.".".end($uploadFileType);
    $imageURL = "../upload/file/".$newName;
    move_uploaded_file($_FILES["uploadFile"]["tmp_name"], $imageURL);

    $sql = "INSERT INTO file (userId, description, fileName, url, createTime) ".
        "VALUES ($userId,'$description','$originalFileName','$imageURL','$createTime') ";
    $connection = createConnection();
    if($connection -> query($sql)){
        $isError = false;
    }
    closeConnection($connection);
}

?>

<script src="../sweetalert/dist/sweetalert-dev.js"></script>
<link rel="stylesheet" href="../sweetalert/dist/sweetalert.css">
<body>

<?
if($isError){
    //    更新失败
    ?>
    <script>
        swal({
            title: "对不起",
            text: "上传文件失败",
            type: "error",
            confirmButtonColor: "#79c9e0",
            confirmButtonText: "确定",
            closeOnConfirm: false
        }, function(){
            window.location.href="fileList.php";
        });
    </script>
<?
}else{
//    更新成功
?>
    <script>
        swal({
            title: "成功",
            text: "上传文件成功",
            type: "success",
            confirmButtonColor: "#79c9e0",
            confirmButtonText: "确定",
            closeOnConfirm: false
        }, function(){
            window.location.href="fileList.php";
        });
    </script>
    <?
}
?>
</body>

