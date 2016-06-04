<?php
/**
 * Created by PhpStorm.
 * User: Ray
 * Date: 16/6/3
 * Time: 21:10
 */
session_start();
include "util.php";
isManager();

$currentPage = $_REQUEST["page"];
$connection = createConnection();
$sql = "SELECT id,userName,sex,name,mobile,isManager,createTime FROM user WHERE isDeleted=0 AND isPassed=0 ORDER BY id DESC LIMIT ".(($currentPage-1)*10).",10";//(页数-1)*每页条数,每页条数
$result = $connection->query($sql);
if($result -> num_rows > 0){
    ?>
    <div class='container alert alert-warning text-center' role='alert'>以下是所有成员的信息,未验证通过的用户无法登录</div>
    <div class='container text-center'>
        <table class="table table-striped table-hover table-bordered">
            <tr>
                <td>id</td>
                <td>姓名</td>
                <td>用户名</td>
                <td>注册时间</td>
                <td>用户类别</td>
                <td>确认通过</td>
            </tr>
<?
    while ($row = $result->fetch_assoc()){
        $id = $row["id"];
        $userName = $row["userName"];
        $name = $row["name"];
        $isManager = $row["isManager"] == 1? "管理员":"用户";
        $createTime = $row["createTime"];
        ?>
        <tr id="tr<? echo $id ?>">
            <td><? echo $id ?></td>
            <td><? echo $name ?></td>
            <td><? echo $userName ?></td>
            <td><? echo $createTime ?></td>
            <td><? echo $isManager ?></td>
            <td>
                <a style="cursor:pointer" class="pass" id="pass<? echo $id ?>"><i class="fa fa-check-square-o" aria-hidden="true"></i></a>
            </td>
        </tr>
            <?
    }
    echo "</table></div>";
}else{
    echo "<div class='container alert alert-warning text-center' role='alert'>暂时没有新用户注册申请</div>";
}
closeConnection($connection);
?>

<script>
    $(".pass").click(function () {
        var userId = this.id.replace(/pass/,"");
        $.post("verificationUserPost.php",{userId:userId},function (data) {
            if(data == "success"){
                swal("成功", "该用户已通过验证", "success");
                $("#tr"+userId).addClass("success");
            }
            else{
                swal("失败", "服务器异常", "error");
            }
        })
    })
</script>
