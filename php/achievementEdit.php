<?php
/**
 * Created by PhpStorm.
 * User: niqianye
 * Date: 16/6/1
 * Time: 13:56
 */
session_start();
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>重新编辑成果</title>
    <script src="../sweetalert/dist/sweetalert-dev.js"></script>
    <link rel="stylesheet" href="../sweetalert/dist/sweetalert.css">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../tinymce/tinymce.js"></script>
    <script>
        tinymce.init({
            selector: '#achievementTextArea',
            language: 'zh_CN',
            height: 400,
            plugins: [
                'advlist autolink link image lists charmap preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars fullscreen insertdatetime nonbreaking',
                'save table contextmenu directionality template paste textcolor'
            ],
            content_css: 'css/content.css',
            toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | preview fullpage | forecolor backcolor emoticons'
        });
    </script>
</head>
<body>
<?php
include "navbar.php";
confirmationUser();

$achievementId = $_REQUEST["achievementId"];
$title = "";
$content = "";
$achievementUserId = null;

$connection = createConnection();
$sql = "SELECT * FROM achievement WHERE isDeleted=0 AND id=".$achievementId;
$result = $connection -> query($sql);
if($result -> num_rows > 0){
    $row = $result -> fetch_assoc();
    $title = $row["title"];
    $content = $row["content"];
    $achievementUserId = $row["userId"];
}
closeConnection($connection);

//如果编辑成果的人和成果作者不同,则不能编辑,管理员也不能
if($_SESSION["userId"] != $achievementUserId){
    ?>
    <script>
        swal({
            title: "对不起",
            text: "您不能编辑该新闻",
            type: "error",
            confirmButtonColor: "#79c9e0",
            confirmButtonText: "确定",
            closeOnConfirm: false
        }, function(){
            window.location = "index.php";
        });
    </script>
<?
    die();
}
?>

<div class="container text-center">

    <div class="form-horizontal">
        <div class="form-group" style="max-width: 70%;margin: auto;margin-top: 5%;margin-bottom: 5%">
            <div class="col-md-12">
                <input type="text" class="form-control" id="achievementTitle" placeholder="标题" value="<? echo $title ?>">
            </div>
        </div>
    </div>

    <div id="achievementTextArea"><? echo $content ?></div>


    <div style="margin-top: 3%;margin-bottom: 3%">
        <button class="btn btn-primary btn-lg" id="btn">提交</button>
        <button class="btn btn-default btn-lg" id="cancel">取消</button>
    </div>
</div>


<script>
    $("#btn").click(function () {
        var achievementContent = tinymce.get('achievementTextArea').getContent();
        var achievementTitle = $("#achievementTitle").val();
        var achievementId = <? echo $achievementId ?>;
        if(!achievementContent || !achievementTitle){
            swal("警告", "请填写完整标题或内容", "warning");
        }
        else if(!achievementId){
            swal("错误", "未获取到成果ID","error");
        }
        else{
            $.post("editAchievementPost.php", {achievementContent:achievementContent,achievementId:achievementId,achievementTitle:achievementTitle}, function (data) {
                if(data == "success"){
                    swal({
                        title: "成功",
                        text: "成功修改该文章",
                        type: "success",
                        confirmButtonColor: "#79c9e0",
                        confirmButtonText: "确定",
                        closeOnConfirm: false
                    }, function(){
                        history.back();
                    });
                }
                else{
                    swal("失败", data, "error");
                }
            })
        }
    });
    $("#cancel").click(function () {
        history.back();
    })
</script>

</body>
</html>

