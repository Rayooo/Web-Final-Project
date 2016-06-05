<?php
/**
 * Created by PhpStorm.
 * User: Ray
 * Date: 16/6/5
 * Time: 14:15
 */
session_start();
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>成果</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../sweetalert/dist/sweetalert-dev.js"></script>
    <link rel="stylesheet" href="../sweetalert/dist/sweetalert.css">
    <style>
        .commentAvatarImage{
            width:80px;
            height:80px;
            line-height: 0;
            display: inline-block;
            border-radius: 50%;
            -moz-border-radius: 50%;
            -webkit-border-radius: 50%;
            transition: linear 0.25s;
        }
        .authorAvatarImage{
            width:120px;
            height:120px;
            line-height: 0;
            display: inline-block;
            border-radius: 50%;
            -moz-border-radius: 50%;
            -webkit-border-radius: 50%;
        }
        #canvas{
            width: 100%;
            height: 100%;
            position:fixed;
            z-index:-1;
        }
        #achievementBackground{
            background-color: rgba(255, 255, 255, 0.9);
        }
        .thumbnail{
            border: 0;
            background-color: rgba(255, 255, 255, 0.9);
        }
    </style>
</head>
<body>

<!--彩带背景-->
<canvas id="canvas"></canvas>
<script src="../js/ribbon.js"></script>

<?php
include "navbar.php";
$achievementId = $_REQUEST["achievementId"];
$achievementTitle = "";
$achievementContent = "";
$createTime = "";
$achievementAuthor = "";

$connection = createConnection();
$sql = "SELECT * FROM achievement WHERE isDeleted=0 AND id=".$achievementId;
$result = $connection -> query($sql);
if($result -> num_rows > 0){
    $row = $result -> fetch_assoc();
    $achievementTitle = $row["title"];
    $achievementContent = $row["content"];
    $createTime = $row["createTime"];
    $achievementAuthor = $row["userId"];
}

$authorName = "";
$authorImage = "";

$sql = "SELECT headImage,name FROM user WHERE id=".$achievementAuthor;
$result = $connection -> query($sql);
if($result -> num_rows > 0){
    $row = $result -> fetch_assoc();
    $authorName = $row["name"];
    $authorImage = $row["headImage"];

}

closeConnection($connection);

?>

<!--成果标题-->
<div class="container text-center">
    <div class="title">
        <h1><? echo $achievementTitle ?></h1>
        <img class="authorAvatarImage" src="<? echo $authorImage ?>">
        <h4><? echo $authorName ?></h4>
        <div>
            <span class="post-time">发表于
                <span><? echo $createTime ?></span>
            </span>
        </div>
    </div>
</div>

<!--成果内容-->
<div class="container" id="achievementBackground"><? echo $achievementContent ?></div>

<div class="container" style="margin-top: 5%;margin-bottom: 5%">
    <a id="previousAchievement" type="button" class="btn btn-info btn-lg">上一篇</a>
    <a id="nextAchievement" type="button" class="btn btn-info btn-lg" style="float: right">下一篇</a>
</div>

<!--评论-->
<div class="container">
    <div class="row" id="comment">
        <div class="col-sm-12 col-md-12">
            <div class="thumbnail col-md-12">
                <div class="caption">
                    <h3>评论</h3>
                    <?php
                    //    先判断有没有评论
                    $isExistComment = false;
                    $existCommentConnection = createConnection();
                    $existCommentSql = "SELECT count(id) FROM achievementcomment WHERE isDeleted=0 AND achievementId=".$achievementId;
                    $existCommentResult = $existCommentConnection -> query($existCommentSql);
                    if($existCommentResult -> num_rows > 0){
                        $existCommentRow = $existCommentResult->fetch_assoc();
                        $isExistComment = $existCommentRow["count(id)"] > 0;
                    }
                    //如果没有评论则输出提示语句,有评论则输出内容
                    if(!$isExistComment){
                        echo "<div class='alert alert-info' role='alert'>暂时还没有评论,快来添加第一个评论吧</div>";
                    }else{
                        $connection = createConnection();
                        $userConnection = createConnection();
                        $sql = "SELECT * FROM achievementcomment WHERE isDeleted=0 AND achievementId=".$achievementId;
                        $result = $connection ->query($sql);

                        if($result -> num_rows > 0 && $achievementTitle != null && $achievementTitle != ""){
                            while ($row = $result -> fetch_assoc()){
                                $commentId = $row["id"];
                                $commentUserId = $row["userId"];
                                $userSql = "SELECT name,headImage FROM user WHERE id=".$commentUserId;
                                $userResult = $userConnection -> query($userSql);
                                if($userResult -> num_rows > 0){
                                    $userRow = $userResult -> fetch_assoc();
                                    $commentUserName = $userRow["name"];
                                    $commentHeadImage = $userRow["headImage"];
                                    $achievementComment = $row["content"];
                                    $commentCreateTime = $row["createTime"];
                                    ?>
                                    <div class="media" style="margin-top: 3%;margin-bottom: 3%" id="comment<? echo $commentId?>">
                                        <div class="media-left media-middle">
                                            <img class="media-object commentAvatarImage" src="<? echo $commentHeadImage?>" alt="...">
                                        </div>
                                        <div class="media-body">
                                            <?
                                            if(isset($_SESSION["userName"]) && ( $commentUserId == $_SESSION["userId"] || $_SESSION["isManager"] == 1 )){
                                                echo "<button class='btn btn-danger deleteButton' id='delete$commentId' style='float: right'>删除</button>";
                                            }
                                            ?>
                                            <h4 class="media-heading"><? echo $commentUserName?></h4>
                                            <? echo $commentCreateTime?><br>
                                            <div style="word-wrap:break-word;word-break:break-all; "><? echo $achievementComment?></div>
                                        </div>
                                    </div>

                                    <?
                                }


                            }
                        }
                        closeConnection($connection);
                        closeConnection($userConnection);

                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!--添加评论框-->
<div class="container" style="margin-bottom: 10%">
    <div class="row">
        <div class="col-lg-12">
            <div class="input-group input-group-lg">
                <input type="text" class="form-control" placeholder="说一句吧" id="achievementComment">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button" id="addComment">评论</button>
                </span>
            </div>
        </div>
    </div>
</div>

<script>
    //前一篇成果
    $("#previousAchievement").click(function () {
        $.post("previousNextAchievement.php",{choice:"previous",currentAchievementId:'<? echo $achievementId ?>'},function (data) {
            if(data != "noAchievement" && data != "null"){
                location.href = "achievementDetail.php?achievementId="+data;
            }
            else if(data == "noAchievement"){
                swal("警告", "没有文章了", "warning");
            }
            else if(data == "null"){
                swal("失败", "发生错误", "error");
            }
        })
    });

    //后一篇成果
    $("#nextAchievement").click(function () {
        $.post("previousNextAchievement.php",{choice:"next",currentAchievementId:'<? echo $achievementId ?>'},function (data) {
            if(data != "noAchievement" && data != "null"){
                location.href = "achievementDetail.php?achievementId="+data;
            }
            else if(data == "noAchievement"){
                swal("警告", "没有文章了", "warning");
            }
            else if(data == "null"){
                swal("失败", "发生错误", "error");
            }
        })
    });


    //删除评论
    $(".deleteButton").click(function () {
        var achievementCommentId = this.id.replace(/delete/,"");
        swal({
            title: "警告",
            text: "您确定要删除此评论?",
            type: "warning",
            showCancelButton: true,
            cancelButtonText: "取消",
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "删除",
            closeOnConfirm: false
        }, function(){
            $.post("deleteAchievementComment.php",{achievementCommentId:achievementCommentId,achievementAuthor:'<? echo $achievementAuthor ?>'},function (data) {
                if(data == "success"){
                    swal("成功", "已删除该评论", "success");
                    var deleteButton = $("#delete"+achievementCommentId);
                    deleteButton.addClass("disabled");
                    deleteButton.html("已删除");
                    deleteButton.unbind("click");
                    $("#comment"+achievementCommentId).remove();
                }
                else{
                    swal("失败", data, "error");
                }
            })
        });
    });


    //添加评论
    $("#addComment").click(function () {
        if(<? echo isset($_SESSION["userName"])==1? "false":"true" ?>){
            //没有登录
            swal("评论失败", "请先登录", "warning");
            return;
        }
        var achievementId = <? echo $achievementId ?>;
        var achievementComment = $("#achievementComment").val();
        if(achievementComment.length > 0){
            $.post("addAchievementComment.php",{achievementId:achievementId,achievementComment:achievementComment},function (data) {
                if(data == "success"){
                    swal({
                        title: "成功",
                        text: "添加评论成功",
                        type: "success",
                        confirmButtonColor: "#79c9e0",
                        confirmButtonText: "确定",
                        closeOnConfirm: false
                    }, function(){
                        location.reload();
                    });
                }
                else{
                    swal("失败", "添加评论失败", "error");
                }
            })
        }else{
            swal("评论失败", "请填写评论内容", "warning");
        }

    })
</script>


</body>
</html>

















