<?php
/**
 * Created by PhpStorm.
 * User: Ray
 * Date: 16/6/4
 * Time: 15:00
 */
session_start();
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>添加新闻</title>
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
?>

<div class="container text-center">

    <div class="form-horizontal">
        <div class="form-group" style="max-width: 70%;margin: auto;margin-top: 5%;margin-bottom: 5%">
            <div class="col-md-12">
                <input type="text" class="form-control" id="newsTitle" placeholder="新闻标题">
            </div>
        </div>
    </div>

    <div id="newsTextArea"></div>

    <div style="margin-top: 3%;margin-bottom: 3%">
        <button class="btn btn-primary btn-lg" id="btn">提交</button>
        <a class="btn btn-default btn-lg" href="index.php">取消</a>
    </div>
</div>


<script>
    $("#btn").click(function () {
        var newsContent = tinymce.get('newsTextArea').getContent();
        var userId = <? echo $_SESSION["userId"] ?>;
        var newsTitle = $("#newsTitle").val();
        if(!newsContent || !newsTitle){
            swal("警告", "请填写完整标题或内容", "warning");
        }
        else{
            $.post("addNewsPost.php", {newsContent:newsContent,userId:userId,newsTitle:newsTitle}, function (data) {
                console.log(data);
                if(data == "success"){
                    swal({
                        title: "成功",
                        text: "成功发表该文章",
                        type: "success",
                        confirmButtonColor: "#79c9e0",
                        confirmButtonText: "确定",
                        closeOnConfirm: false
                    }, function(){
                        window.location.href = "newsList.php";
                    });
                }
                else{
                    swal("失败", "服务器异常", "error");
                }
            })
        }
    })
</script>

</body>
</html>
