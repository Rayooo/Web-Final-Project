<?php
/**
 * Created by PhpStorm.
 * User: Ray
 * Date: 16/6/5
 * Time: 12:36
 */
session_start();
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>搜索新闻</title>
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
?>
<div class="container" style="margin-bottom: 3%">
    <div class="row">
        <div class="col-lg-12">
            <div class="input-group input-group-lg">
                <input type="text" class="form-control" placeholder="请输入新闻标题" id="searchNews" v-model="newsTitle">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button" id="searchButton">搜索</button>
                </span>
            </div>
        </div>
    </div>
</div>

<?php
$count = 0;
$connection = createConnection();
$sql = "SELECT count(id) FROM news WHERE isDeleted=0";
$result = $connection -> query($sql);
if($result -> num_rows > 0){
    $row = $result -> fetch_assoc();
    $count = ceil($row["count(id)"] / 10.0);
}
closeConnection($connection);
?>


<!--搜索结果,一开始不显示-->
<div id="searchResult"></div>

<!--内容-->
<div id="newsListTable"></div>

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
        $.post("searchNewsTable.php",{page:1},function (data) {
            $("#newsListTable").html(data);
            checkPreviousAndNext();
        })
    });

    $(".pagingA").click(function () {
        $(".paging").removeClass("active");
        $("#paging"+this.innerHTML).addClass("active");
        currentPage = parseInt(this.innerHTML);
        $.post("searchNewsTable.php",{page:this.innerHTML},function (data) {
            $("#newsListTable").html(data);
        });
        checkPreviousAndNext();
    });
    //上一页的按钮被按下
    $("#previous").click(function () {
        if(currentPage > 1){
            currentPage -= 1;
            $(".paging").removeClass("active");
            $("#paging" + currentPage).addClass("active");
            $.post("searchNewsTable.php", {page:currentPage}, function (data) {
                $("#newsListTable").html(data);
            });
            checkPreviousAndNext();
        }
    });
    //下一页的按钮被按下
    $("#next").click(function () {
        if(currentPage < <? echo $count ?>){
            currentPage += 1;
            console.log(currentPage);
            $(".paging").removeClass("active");
            $("#paging" + currentPage).addClass("active");
            $.post("searchNewsTable.php", {page:currentPage}, function (data) {
                $("#newsListTable").html(data);
            });
            checkPreviousAndNext();
        }
    });

    //搜索
    //    $("#searchButton").click(function () {
    //        var newsTitle = $("#searchNews").val();
    //        $.post("searchNewsData.php",{newsTitle:newsTitle},function (data) {
    //            if(data != ""){
    //                $("#newsListTable").hide();
    //                $("#footerNav").hide();
    //                $("#searchResult").html(data);
    //            }
    //        })
    //    })
    //Vue优化查询,但是服务器压力会变大
    var searchVue = new Vue({
        el:"#searchNews",
        data:{
            newsTitle: ""
        }
    });
    searchVue.$watch('newsTitle',function (val) {
        if(val.length > 0){
            $.post("searchNewsData.php",{newsTitle:val},function (data) {
                if(data != ""){
                    var searchResult = $("#searchResult");
                    searchResult.show();
                    $("#newsListTable").hide();
                    $("#footerNav").hide();
                    searchResult.html(data);
                }
            })
        }
        else{
            $("#searchResult").hide();
            $("#newsListTable").show();
            $("#footerNav").show();
        }
    })


</script>


</body>
</html>

