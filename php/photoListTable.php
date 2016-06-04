<?php
/**
 * Created by PhpStorm.
 * User: Ray
 * Date: 16/6/4
 * Time: 18:48
 */
session_start();
include "util.php";
isLogin();

$currentPage = $_REQUEST["page"];
$connection = createConnection();
$sql = "SELECT * FROM photo WHERE isDeleted=0 ORDER BY id DESC LIMIT ".(($currentPage-1)*9).",9";//(页数-1)*每页条数,每页条数
$result = $connection->query($sql);
if($result -> num_rows > 0){
    $imageCount = 1;
    while ($row = $result -> fetch_assoc()){
        if($imageCount % 3 == 0){
            echo "<div class='row'>";
        }
        ?>
        <div class="col-sm-4 col-md-4">
            <div class="thumbnail">
                <img src="<? echo $row["url"] ?>" alt="">
                <div class="caption">
                    <p>描述: <? echo $row["description"]==""? "无" :$row["description"] ?></p>
                    <p>上传时间: <? echo $row["createTime"] ?></p>
                    <p>引用链接: <? echo $row["url"] ?></p>
<?
                    if(isset($_SESSION["userName"]) && ( $row["userId"] == $_SESSION["userId"] || $_SESSION["isManager"] == 1 )){
                        $photoId = $row["id"];
                        echo "<p><button class='btn btn-danger deleteButton' id='delete$photoId'>删除</button></p>";
                    }
?>
                </div>
            </div>
        </div>
                    <?
        if($imageCount % 3 == 0){
            echo "</div>";
        }
        $imageCount++;
    }
}
closeConnection($connection);
?>

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="modalImage">
    <div class="modal-dialog modal-lg">
        <div class="modal-content text-center">
            <img id="bigImage" src="" style="max-width: 100%">
        </div>
    </div>
</div>



<script>
    $(".deleteButton").click(function () {
        var photoId = this.id.replace(/delete/,"");
        swal({
            title: "警告",
            text: "您确定要删除此照片?",
            type: "warning",
            showCancelButton: true,
            cancelButtonText: "取消",
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "删除",
            closeOnConfirm: false
        }, function(){
            $.post("deletePhoto.php",{photoId:photoId},function (data) {
                if(data == "success"){
                    swal("成功", "已删除该照片", "success");
                    var deleteButton = $("#delete"+photoId);
                    deleteButton.addClass("disabled");
                    deleteButton.html("已删除");
                    deleteButton.unbind("click");
                }
                else{
                    swal("失败", data, "error");
                }
            })
        });
    });

    $("img").click(function () {
        $("#bigImage").attr("src",this.src);
        $("#modalImage").modal("show")
    })

</script>

