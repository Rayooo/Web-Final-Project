<?php
/**
 * Created by PhpStorm.
 * User: Ray
 * Date: 16/6/5
 * Time: 13:57
 */
session_start();
include "util.php";
isManager();

$currentPage = $_REQUEST["page"];
$connection = createConnection();
$sql = "SELECT * FROM achievement WHERE isDeleted=0 ORDER BY id DESC LIMIT ".(($currentPage-1)*10).",10";//(页数-1)*每页条数,每页条数
$result = $connection -> query($sql);
if($result -> num_rows > 0){
    ?>
    <div class='container alert alert-success text-center' role='alert'>以下是所有成果的信息</div>
    <div class='container text-center'>
        <table class="table table-striped table-hover table-bordered">
            <tr>
                <td>标题</td>
                <td>创建时间</td>
                <td>操作</td>
            </tr>
<?
    while ($row = $result -> fetch_assoc()){
        $id = $row["id"];
        $title = $row["title"];
        $createTime = $row["createTime"];
        ?>
            <tr id="tr<? echo $id ?>">
                <td style="cursor:pointer" class="tdTitle" id="tdTitle<? echo $id ?>"><? echo $title ?></td>
                <td><? echo $createTime ?></td>
                <td>
                    <a target="_blank" href="achievementDetail.php?achievementId=<? echo $id ?>"><i class="fa fa-newspaper-o" aria-hidden="true"></i></a>
                    <a style="cursor: pointer" class="delete" id="delete<? echo $id ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                </td>
            </tr>
            <?
    }
    ?>
        </table>
    </div>

            <?
}else{
    echo "<div class='container alert alert-warning text-center' role='alert'>没有成果发布</div>";
}
closeConnection($connection);
?>

<script>
    $(".delete").click(function () {
        var achievementId = this.id.replace(/delete/,"");
        swal({
            title: "警告",
            text: "您确定要删除此成果?",
            type: "warning",
            showCancelButton: true,
            cancelButtonText: "取消",
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "删除",
            closeOnConfirm: false
        }, function(){
            $.post("deleteAchievementPost.php",{achievementId:achievementId},function (data) {
                if(data == "success"){
                    swal("成功", "已删除该成果", "success");
                    $("#tr"+achievementId).addClass("danger");
                }
                else{
                    swal("失败", "服务器异常", "error");
                }
            })
        });
    });

    $(".tdTitle").click(function () {
        var achievementId = this.id.replace(/tdTitle/,"");
        window.open("achievementDetail.php?achievementId="+achievementId);
    })

</script>
