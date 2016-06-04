<?php
/**
 * Created by PhpStorm.
 * User: Ray
 * Date: 16/6/4
 * Time: 10:50
 */
session_start();
include "util.php";
isManager();
$currentPage = $_REQUEST["page"];
$currentUserId = $_SESSION["userId"];

$connection = createConnection();
$sql = "SELECT id,userName,sex,name,mobile,isManager,isPassed FROM user WHERE id!=".$currentUserId." AND isDeleted=0 ORDER BY id DESC LIMIT ".(($currentPage-1)*10).",10";//(页数-1)*每页条数,每页条数
$result = $connection -> query($sql);
if($result -> num_rows > 0) {
    ?>
    <div class='container alert alert-success text-center' role='alert'>以下是所有成员的信息</div>
    <div class='container text-center'>
        <table class="table table-striped table-hover table-bordered">
            <tr>
                <td>id</td>
                <td>姓名</td>
                <td>手机</td>
                <td>用户名</td>
                <td>性别</td>
                <td>用户类别</td>
                <td>是否通过验证</td>
                <td>操作</td>
            </tr>
<?
    while ($row = $result -> fetch_assoc()){
        $id = $row["id"];
        $userName = $row["userName"];
        $sex = $row["sex"] == 1? "男":"女";
        $name = $row["name"];
        $mobile = $row["mobile"];
        $isManager = $row["isManager"] == 1? "管理员":"用户";
        $isPassed = $row["isPassed"] == 1? "通过":"未通过";
        if($isPassed == "未通过"){
            echo "<tr id='tr$id' class='warning'>";
        }else{
            echo "<tr id='tr$id'>";
        }
?>
        <td><? echo $id ?></td>
        <td><? echo $name ?></td>
        <td><? echo $mobile==null? "":$mobile ?></td>
        <td><? echo $userName ?></td>
        <td><? echo $sex ?></td>
        <td><? echo $isManager ?></td>
        <td><? echo $isPassed ?></td>
        <td>
            <a style="cursor: pointer" class="showUserInfo" id="showUserInfo<? echo $id ?>"><i class="fa fa-child" aria-hidden="true"></i></a>
            <a target="_blank" href="userInfoEdit.php?id=<? echo $id ?>"><i class="fa fa-cog" aria-hidden="true"></i></a>
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
    echo "<div class='container alert alert-warning text-center' role='alert'>未查询到信息</div>";
}

closeConnection($connection);
?>
            
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="userInfoModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div style="max-width: 100%" id="userInfoModalContent">
            </div>
        </div>
    </div>
</div>

<script>
    $(".delete").click(function () {
        var userId = this.id.replace(/delete/,"");
        swal({
            title: "警告",
            text: "您确定要删除此用户?",
            type: "warning",
            showCancelButton: true,
            cancelButtonText: "取消",
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "删除",
            closeOnConfirm: false
        }, function(){
            $.post("/deleteUser",{userId:userId},function (data) {
                if(data == "success"){
                    swal("成功", "已删除该用户", "success");
                    $("#tr"+userId).remove();
                }
                else{
                    swal("失败", "服务器异常", "error");
                }
            })
        });
    });

    $(".showUserInfo").click(function () {
        var userId = this.id.replace(/showUserInfo/,"");
        $.post("userInfo.php",{userId:userId},function (data) {
            if(data != ""){
                $("#userInfoModalContent").html(data);
                $("#userInfoModal").modal("show")
            }
        })

    })
</script>
            
            