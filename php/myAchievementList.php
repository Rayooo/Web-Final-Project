<?php
/**
 * Created by PhpStorm.
 * User: Ray
 * Date: 16/6/5
 * Time: 13:03
 */
session_start();
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>我的成果</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../sweetalert/dist/sweetalert-dev.js"></script>
    <link rel="stylesheet" href="../sweetalert/dist/sweetalert.css">
</head>
<body>
<?php
include "navbar.php";
confirmationUser();

$userId = $_SESSION["userId"];

$connection = createConnection();
$sql = "SELECT * FROM achievement WHERE isDeleted=0 AND userId=$userId ORDER BY id DESC ";
$result = $connection -> query($sql);
if($result -> num_rows > 0){
    ?>
    <div class='container alert alert-success text-center' role='alert'>以下是您发表的成果</div>
    <div class='container text-center'>
        <table class="table table-striped table-hover table-bordered">
            <tr>
                <td>成果标题</td>
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
                    <a href="achievementDetail.php?achievementId=<? echo $id ?>"><i class="fa fa-newspaper-o" aria-hidden="true"></i></a>
                    <a href="achievementEdit.php?achievementId=<? echo $id ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
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
    echo "<div class='container alert alert-warning text-center' role='alert'>您未发表成果</div>";
}

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
            $.post("deleteAchievement.php",{achievementId:achievementId},function (data) {
                if(data == "success"){
                    swal("成功", "已删除该成果", "success");
                    $("#tr"+achievementId).addClass("danger");
                }
                else{
                    swal("失败", data, "error");
                }
            })
        });
    });

    $(".tdTitle").click(function () {
        var achievementId = this.id.replace(/tdTitle/,"");
        window.location.href = "achievementDetail.php?achievementId="+achievementId;
    })

</script>
</body>
</html>

