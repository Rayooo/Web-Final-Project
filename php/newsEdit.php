<?php
/**
 * Created by PhpStorm.
 * User: Ray
 * Date: 16/6/4
 * Time: 16:15
 */
session_start();
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>重新编辑新闻</title>
    <script src="../sweetalert/dist/sweetalert-dev.js"></script>
    <link rel="stylesheet" href="../sweetalert/dist/sweetalert.css">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../tinymce/tinymce.js"></script>
    <script>
        tinymce.init({
            selector: '#newsTextArea',
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
confirmationManager();
$newsId = $_REQUEST["newsId"];
$title = "";
$content = "";

$connection = createConnection();
$sql = "SELECT * FROM news WHERE isDeleted=0 AND id=".$newsId;
$result = $connection -> query($sql);
if($result -> num_rows > 0){
    $row = $result->fetch_assoc();
    $title = $row["title"];
    $content = $row["content"];
}
closeConnection($connection);
?>

<div class="container text-center">

    <div class="form-horizontal">
        <div class="form-group" style="max-width: 70%;margin: auto;margin-top: 5%;margin-bottom: 5%">
            <div class="col-md-12">
                <input type="text" class="form-control" id="newsTitle" placeholder="新闻标题" value=" <? echo $title ?>">
            </div>
        </div>
    </div>

    <div id="newsTextArea"> <? echo $content ?></div>

    <div style="margin-top: 3%;margin-bottom: 3%">
        <button class="btn btn-primary btn-lg" id="btn">提交</button>
        <button class="btn btn-default btn-lg" id="cancel">取消</button>
    </div>
</div>


<script>
    $("#btn").click(function () {
        var newsContent = tinymce.get('newsTextArea').getContent();
        var newsTitle = $("#newsTitle").val();
        var newsId =  <? echo $newsId ?>;
        if(!newsContent || !newsTitle){
            swal("警告", "请填写完整标题或内容", "warning");
        }
        else if(!newsId){
            swal("错误", "未获取到新闻ID","error");
        }
        else{
            $.post("newsEditPost.php", {newsContent:newsContent,newsId:newsId,newsTitle:newsTitle}, function (data) {
                if(data == "success"){
                    swal({
                        title: "成功",
                        text: "成功修改该文章",
                        type: "success",
                        confirmButtonColor: "#79c9e0",
                        confirmButtonText: "确定",
                        closeOnConfirm: false
                    }, function(){
                        window.close();
                    });
                }
                else{
                    swal("失败", "服务器异常", "error");
                }
            })
        }
    });
    $("#cancel").click(function () {
        window.close();
    })
</script>


</body>
</html>

