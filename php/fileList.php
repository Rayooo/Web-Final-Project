<?php
/**
 * Created by PhpStorm.
 * User: Ray
 * Date: 16/6/4
 * Time: 19:58
 */
session_start();
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>文件库</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../sweetalert/dist/sweetalert-dev.js"></script>
    <link rel="stylesheet" href="../sweetalert/dist/sweetalert.css">
    <script src="../js/vue.js"></script>
</head>
<body>

<?php
include "navbar.php";
confirmationLogin();
?>

<div class="container bg-info" style="padding-top: 5%;padding-bottom: 5%;margin-bottom: 2%">
    <h1 class="text-center">这里可以上传文件,与朋友们分享</h1>
    <form class="form-horizontal" method="post" action="uploadFile.php" enctype="multipart/form-data">
        <div class="row" style="margin-top: 3%">
            <div class="col-xs-12 col-sm-12 col-md-12" style="margin-bottom: 3%">
                <input class="form-control" type="text" name="description" id="description" placeholder="可填写文件描述">
            </div>
            <div class="col-xs-7 col-sm-7 col-md-7" style="padding-top: 1%">
                <input type="file" style="float: right" name="uploadFile" id="uploadFile" required>
            </div>
            <div class="col-xs-5 col-sm-5 col-md-5">
                <button type="submit" class="btn btn-info" id="uploadImageButton">上传</button>
            </div>
        </div>
    </form>
</div>

<div class="container" style="margin-bottom: 4%">
    <div class="row">
        <div class="col-lg-12">
            <div class="input-group input-group-lg">
                <input type="text" class="form-control" placeholder="请输入文件名进行搜索" id="searchFile" v-model="fileName">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button" id="searchButton">搜索</button>
                </span>
            </div>
        </div>
    </div>
</div>

<!--搜索结果,一开始不显示-->
<div class="container" id="searchResult" style="margin-bottom: 10%"></div>

<?php
$count = 0;
$connection = createConnection();
$sql = "SELECT count(id) FROM file WHERE isDeleted=0";
$result = $connection -> query($sql);
if($result -> num_rows > 0){
    $row = $result -> fetch_assoc();
    $count = ceil($row["count(id)"] / 10.0);
}
closeConnection($connection);
?>

<!--内容-->
<div class="container" id="fileListTable"></div>

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
        $.post("fileListTable.php",{page:1},function (data) {
            $("#fileListTable").html(data);
            checkPreviousAndNext();
        });
        $("#description").hide();
        $("#searchResult").hide();
    });

    $(".pagingA").click(function () {
        $(".paging").removeClass("active");
        $("#paging"+this.innerHTML).addClass("active");
        currentPage = parseInt(this.innerHTML);
        $.post("fileListTable.php",{page:this.innerHTML},function (data) {
            $("#fileListTable").html(data);
        });
        checkPreviousAndNext();
    });

    $("#previous").click(function () {
        if(currentPage > 1){
            currentPage -= 1;
            $(".paging").removeClass("active");
            $("#paging" + currentPage).addClass("active");
            $.post("fileListTable.php", {page:currentPage}, function (data) {
                $("#fileListTable").html(data);
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
            $.post("fileListTable.php", {page:currentPage}, function (data) {
                $("#fileListTable").html(data);
            });
            checkPreviousAndNext();
        }
    });

    //显示描述框
    $("body").on("change", "#uploadFile", function (){
        $("#description").show();
    });

    //Vue优化查询,但是服务器压力会变大
    var searchVue = new Vue({
        el:"#searchFile",
        data:{
            fileName: ""
        }
    });
    searchVue.$watch('fileName',function (val) {
        if(val.length > 0){
            $.post("searchFileData.php",{fileName:val},function (data) {
                if(data != ""){
                    var searchResult = $("#searchResult");
                    searchResult.show();
                    $("#fileListTable").hide();
                    $("#footerNav").hide();
                    searchResult.html(data);
                }
            })
        }else{
            $.post("fileListTable.php",{page:currentPage},function (data) {
                $("#fileListTable").html(data).show();
                checkPreviousAndNext();
                $("#searchResult").hide();
                $("#footerNav").show();
            });
        }

    })

</script>


</body>
</html>



