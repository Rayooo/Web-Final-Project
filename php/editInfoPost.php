<?php
/**
 * Created by PhpStorm.
 * User: niqianye
 * Date: 16/5/26
 * Time: 21:56
 */
session_start();
include "util.php";
isLogin();

$userName = $_REQUEST["userName"];
$password = $_REQUEST["password"];
$name = $_REQUEST["name"];
$mobile = $_REQUEST["mobile"];
$sex = $_REQUEST["sex"];
$introduction = $_REQUEST["introduction"];
$id = $_REQUEST["userId"];

$isError = true;

//是否上传文件
if(!empty($_FILES["image"]["tmp_name"])){
    $uploadFileType = explode(".", $_FILES["image"]["name"]);
    $now = date("YmdHis");
    $randNum = rand(10000,99999);
    $newName = $now.$randNum.".".end($uploadFileType);
    $imageURL = "../upload/headImage/".$newName;
    move_uploaded_file($_FILES["image"]["tmp_name"], $imageURL);

    $sql = "UPDATE user SET userName='$userName',password='$password',sex=$sex,name='$name',introduction='$introduction',headImage='$imageURL',mobile='$mobile' WHERE id=$id";
    $connection = createConnection();
    if($connection -> query($sql)){
        $isError = false;
    }
    closeConnection($connection);
}else{
    $connection = createConnection();
    $sql = "UPDATE user SET userName='$userName',password='$password',sex=$sex,name='$name',introduction='$introduction',mobile='$mobile' WHERE id=$id";
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
            var url = document.referrer;
            var rawIndex = url.substring(url.lastIndexOf('/'));
            var indexArr = rawIndex.split('?');
            var preLocation = indexArr[0];

            swal({
                title: "对不起",
                text: "更新信息失败",
                type: "error",
                confirmButtonColor: "#79c9e0",
                confirmButtonText: "确定",
                closeOnConfirm: false
            }, function(){
                if(preLocation == "/userInfoEdit.php"){
                    window.close();
                }else if(preLocation == "/editMyInfo.php"){
                    window.location = "editMyInfo.php";
                }
            });
        </script>
    <?
    }else{
    //    更新成功
    ?>
        <script>
            var url = document.referrer;
            var rawIndex = url.substring(url.lastIndexOf('/'));
            var indexArr = rawIndex.split('?');
            var preLocation = indexArr[0];

            swal({
                title: "成功",
                text: "更新信息成功",
                type: "success",
                confirmButtonColor: "#79c9e0",
                confirmButtonText: "确定",
                closeOnConfirm: false
            }, function(){
                if(preLocation == "/userInfoEdit.php"){
                    window.close();
                }else if(preLocation == "/editMyInfo.php"){
                    window.location = "editMyInfo.php";
                }
            });
        </script>
        <?
    }
    ?>
</body>
