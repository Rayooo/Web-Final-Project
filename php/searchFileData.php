<?php
/**
 * Created by PhpStorm.
 * User: Ray
 * Date: 16/6/4
 * Time: 20:39
 */
session_start();
include "util.php";

$fileName = $_REQUEST["fileName"];

$connection = createConnection();
$userConnection = createConnection();
$sql = "SELECT * FROM file WHERE isDeleted=0 AND fileName LIKE '%$fileName%'";
$result = $connection -> query($sql);
$fileCount = 1;
if($result -> num_rows > 0){
    while ($row = $result -> fetch_assoc()){
        $fileId = $row["id"];
        $originalFileName = $row["fileName"];
        $url = $row["url"];
        $createTime = $row["createTime"];
        $description = $row["description"];

        $uploadFileUserId = $row["userId"];

        $userSql = "SELECT name FROM user WHERE id=".$uploadFileUserId;
        $userResult = $userConnection -> query($userSql);
        $uploadFileUserName = "";
        if($userResult -> num_rows > 0){
            $userRow = $userResult -> fetch_assoc();
            $uploadFileUserName = $userRow["name"];
        }

        if($fileCount % 2 == 0){
            echo "<div class='row'>";
        }
        $fileNameArr = explode(".", $originalFileName);
        $suffix = end($fileNameArr);
        ?>
        <div class="media col-md-6" style="margin-top: 0">
            <div class="media-left">
                <a href="#">
                    <?
                    if($suffix=="avi" || $suffix=="doc" ||
                        $suffix=="html" || $suffix=="js" ||
                        $suffix=="mp3" || $suffix=="mp4" ||
                        $suffix=="pdf" || $suffix=="xls" ||
                        $suffix=="zip" || $suffix=="docx" ||
                        $suffix=="xlsx"){
                        echo "<img class='media-object' src='../image/$suffix.png' alt='...'>";
                    }else{
                        echo "<img class='media-object' src='../image/file.png' alt='...'>";
                    }
                    ?>
                </a>
            </div>
            <div class="media-body">
                <h4 class="media-heading">文件名:<? echo $originalFileName ?></h4>
                <p>上传者:<? echo $uploadFileUserName ?></p>
                <p>描述:<? echo $description == ""? "无":$description ?></p>
                <p>引用链接:<? echo $url ?></p>
                <p>上传时间:<? echo $createTime ?></p>
                <p>
                    <a class="btn btn-success" id="download<? echo $fileId ?>" download="<? echo $row["fileName"] ?>" href="<? echo $row["url"] ?>">下载</a>
                    <?
                    if(isset($_SESSION["userName"]) && ( $row["userId"] == $_SESSION["userId"] || $_SESSION["isManager"] == 1 )){
                        $photoId = $row["id"];
                        echo "<button class='btn btn-danger deleteButton' id='delete$photoId'>删除</button>";
                    }
                    ?>
                </p>
            </div>
        </div>
        <?
        if($fileCount % 2 == 0){
            echo "</div>";
        }
        $fileCount ++;
    }
}
closeConnection($userConnection);
closeConnection($connection);
?>

<script>
    $(".deleteButton").click(function () {
        var fileId = this.id.replace(/delete/,"");
        swal({
            title: "警告",
            text: "您确定要删除此文件?",
            type: "warning",
            showCancelButton: true,
            cancelButtonText: "取消",
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "删除",
            closeOnConfirm: false
        }, function(){
            $.post("deleteFile.php",{fileId:fileId},function (data) {
                if(data == "success"){
                    swal("成功", "已删除该文件", "success");
                    var deleteButton = $("#delete"+fileId);
                    deleteButton.addClass("disabled");
                    deleteButton.html("已删除");
                    deleteButton.unbind("click");
                    $("#download"+fileId).remove();
                }
                else{
                    swal("失败", data, "error");
                }
            })
        });
    })
</script>

