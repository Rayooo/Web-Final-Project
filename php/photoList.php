<?php
/**
 * Created by PhpStorm.
 * User: Ray
 * Date: 16/6/4
 * Time: 18:42
 */
session_start();
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>图片库</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../sweetalert/dist/sweetalert-dev.js"></script>
    <link rel="stylesheet" href="../sweetalert/dist/sweetalert.css">
</head>
<body>

<?php
include "navbar.php";
confirmationLogin();
?>

<div class="container bg-success" style="padding-top: 5%;padding-bottom: 5%;margin-bottom: 5%">
    <h1 class="text-center">这里可以上传照片,记录我们的点滴</h1>
    <div class="text-center">
        <img id="preview" style="max-width: 100%" src="">
    </div>
    <form class="form-horizontal" method="post" action="uploadImage.php" enctype="multipart/form-data">
        <div class="row" style="margin-top: 3%">
            <div class="col-xs-12 col-sm-12 col-md-12" style="margin-bottom: 3%">
                <input class="form-control" type="text" name="description" id="description" placeholder="可填写照片描述">
            </div>
            <div class="col-xs-7 col-sm-7 col-md-7 text-left" style="padding-top: 1%">
                <input type="file" style="float: right;" accept="image/*" name="uploadImage" id="uploadImage" required>
            </div>
            <div class="col-xs-5 col-sm-5 col-md-5">
                <button type="submit" class="btn btn-info" id="uploadImageButton">上传</button>
            </div>
        </div>
    </form>
</div>

<?php
$count = 0;
$connection = createConnection();
$sql = "SELECT count(id) FROM photo WHERE isDeleted=0";
$result = $connection -> query($sql);
if($result -> num_rows > 0){
    $row = $result -> fetch_assoc();
    $count = ceil($row["count(id)"] / 9.0);
}
closeConnection($connection);

?>
<!--内容-->
<div class="container" id="photoListTable"></div>

<!--分页-->
<nav class="text-center" id="footerNav">
    <ul class="pagination pagination-lg" style="cursor:pointer">
        <li id="previous"><a aria-label="Previous">&laquo;</a></li>

        <li class="active paging" id="paging1"><a class="pagingA">1</a></li>
        <?
        for ($i = 2; $i <= $count; ++$i){
            echo "<li class='paging' id='paging$i'><a class='pagingA'>$i</a></li>";
        }
        ?>
        <li id="next"><a aria-label="Previous">&raquo;</a></li>
    </ul>
</nav>

<script>
    var currentPage = 1;
    //检查是否为最前面或最后页,如果是,则禁用按钮
    function checkPreviousAndNext() {
        if(currentPage == 1){
            $("#previous").addClass("disabled");
        }
        else{
            $("#previous").removeClass("disabled");
        }

        if(currentPage >= <? echo $count ?>){
            $("#next").addClass("disabled");
        }
        else{
            $("#next").removeClass("disabled");
        }
    }

    $(document).ready(function () {
        $.post("photoListTable.php",{page:1},function (data) {
            $("#photoListTable").html(data);
            checkPreviousAndNext();
        });
        $("#description").hide();
    });

    $(".pagingA").click(function () {
        $(".paging").removeClass("active");
        $("#paging"+this.innerHTML).addClass("active");
        currentPage = parseInt(this.innerHTML);
        $.post("photoListTable.php",{page:this.innerHTML},function (data) {
            $("#photoListTable").html(data);
        });
        checkPreviousAndNext();
    });

    $("#previous").click(function () {
        if(currentPage > 1){
            currentPage -= 1;
            $(".paging").removeClass("active");
            $("#paging" + currentPage).addClass("active");
            $.post("photoListTable.php", {page:currentPage}, function (data) {
                $("#photoListTable").html(data);
            });
            checkPreviousAndNext();
        }
    });
    $("#next").click(function () {
        if(currentPage < <? echo $count ?>){
            currentPage += 1;
            console.log(currentPage);
            $(".paging").removeClass("active");
            $("#paging" + currentPage).addClass("active");
            $.post("photoListTable.php", {page:currentPage}, function (data) {
                $("#photoListTable").html(data);
            });
            checkPreviousAndNext();
        }
    });


    //预览图片
    function preview(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#preview').attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
            $("#description").show();
        }
    }

    $("body").on("change", "#uploadImage", function (){
        preview(this);
    });

</script>


</body>
</html>

