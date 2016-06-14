<?php
/**
 * Created by PhpStorm.
 * User: Ray
 * Date: 16/6/1
 * Time: 14:56
 */
session_start();
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>成果列表</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../sweetalert/dist/sweetalert-dev.js"></script>
    <link rel="stylesheet" href="../sweetalert/dist/sweetalert.css">
</head>
<body>
<?php
include "navbar.php";
confirmationManager();

$count = 0;
$connection = createConnection();
$sql = "SELECT count(id) FROM achievement WHERE isDeleted=0";
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
<div id="achievementListTable"></div>

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
        $.post("achievementListTable.php",{page:1},function (data) {
            $("#achievementListTable").html(data);
            checkPreviousAndNext();
        })
    });

    $(".pagingA").click(function () {
        $(".paging").removeClass("active");
        $("#paging"+this.innerHTML).addClass("active");
        currentPage = parseInt(this.innerHTML);
        $.post("achievementListTable.php",{page:this.innerHTML},function (data) {
            $("#achievementListTable").html(data);
        });
        checkPreviousAndNext();
    });
    //上一页的按钮被按下
    $("#previous").click(function () {
        if(currentPage > 1){
            currentPage -= 1;
            $(".paging").removeClass("active");
            $("#paging" + currentPage).addClass("active");
            $.post("achievementListTable.php", {page:currentPage}, function (data) {
                $("#achievementListTable").html(data);
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
            $.post("achievementListTable.php", {page:currentPage}, function (data) {
                $("#achievementListTable").html(data);
            });
            checkPreviousAndNext();
        }
    });

</script>

</body>
</html>
