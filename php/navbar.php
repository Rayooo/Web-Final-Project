<?php
/**
 * Created by PhpStorm.
 * User: Ray
 * Date: 16/6/3
 * Time: 13:58
 */
include "util.php";
?>
<link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css">
<script src="../sweetalert/dist/sweetalert-dev.js"></script>
<link rel="stylesheet" href="../sweetalert/dist/sweetalert.css">
<!--导航条-->
<nav class="navbar navbar-default">
    <div class="container">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbarCollapse1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php"><i class="fa fa-leaf" aria-hidden="true"></i>社团展示平台</a>
            </div>

            <div class="collapse navbar-collapse" id="navbarCollapse1">
                <ul class="nav navbar-nav navbar-right">

                    <?php
                    if(isset($_SESSION["userName"])){
                        $userNameNavBar = $_SESSION["userName"];
                    }else{
                        $userNameNavBar = null;
                    }
                    if($userNameNavBar == null){
                        echo "<button type='button' style='margin-right: 3px' class='btn btn-primary navbar-btn' data-toggle='modal' data-target='#loginModal'>登陆</button>";
                        echo "<a type='button' class='btn btn-primary navbar-btn' href='register.php'>注册</a>";
                    }else{
                        $isManager = isset($_SESSION["isManager"])? null:$_SESSION["isManager"];
                        if($isManager == 1) {
                            echo "<a type='button' class='btn btn-primary navbar-btn' href='logout.php'>退出</a>";
                            echo "<li class='naviButton' id='navIndex'><a href='index.php'>主页</a></li>";


                            ?>

                            <li class="dropdown" id="navUser">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                   aria-haspopup="true" aria-expanded="false">成员管理 <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="verificationUserList.php">成员审核</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="userList.php">成员信息</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="achievementList.php">成果管理</a></li>
                                </ul>
                            </li>

                            <li class="dropdown" id="navNews">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                   aria-haspopup="true" aria-expanded="false">新闻管理 <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="addNews.php">添加新闻</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="newsList.php">新闻修改</a></li>
                                </ul>
                            </li>

                            <li class="dropdown" id="navShare">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                   aria-haspopup="true" aria-expanded="false">资源<span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="photoList.php">图片库</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="fileList.php">文件库</a></li>
                                </ul>
                            </li>

                            <?php
                            echo "<li class='naviButton' id='navMyInfo'><a href='editMyInfo.php'>个人信息</a></li>";
                        }
                        else{
                            echo "<a type='button' class='btn btn-primary navbar-btn' href='logout.php'>退出</a>";
                            echo "<li class='naviButton' id='navIndex'><a href='index.php'>主页</a></li>";
                    ?>

                            <li class="dropdown" id="navAchievement">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">成果<span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="addAchievement.php">发表成果</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="myAchievementList.php">我的成果</a></li>
                                </ul>
                            </li>
                            <li class="dropdown" id="navShare">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">资源<span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="photoList.php">图片库</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="fileList.php">文件库</a></li>
                                </ul>
                            </li>
                    <?php
                            echo "<li class='naviButton' id='navMyInfo'><a href='editMyInfo.php'>个人信息</a></li>";
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</nav>
<!--登陆框-->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title text-center" id="loginModalLabel">登陆</h3>
            </div>
            <div class="modal-body">
                <form method="post">
                    <label for="userNameNavBar" class="sr-only">用户名</label>
                    <input type="text" name="userNameNavBar" id="userNameNavBar" class="form-control" placeholder="用户名" required autofocus>
                    <label for="passwordNavBar" class="sr-only">密码</label>
                    <input type="password" name="passwordNavBar" id="passwordNavBar" class="form-control" placeholder="密码" required>
                    <div class="text-center" id="loginButtons">
                        <button type="button" class="btn btn-success" id="loginButton">登陆</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    #loginButtons{
        margin-top: 3%;
    }
    #userNameNavBar{
        margin-bottom: 3%;
    }
</style>
<script>
    $("#loginButton").click(function () {
        var userName = $("#userNameNavBar").val();
        var password = $("#passwordNavBar").val();
        if( !!userName && !!password){
            $.post("/login",{userNameNavBar:userName,passwordNavBar:password},function (data) {
                if(data == "success"){
                    location.reload();
                }
                else{
                    swal("错误",data,"warning");
                }
            })
        }
    });

    $(function () {
        //获取url最后一个参数
        var url= window.location.href;
        var rawIndex = url.substring(url.lastIndexOf('/'));
        var indexArr = rawIndex.split('?');
        //地址栏最后一个值如 /index.php
        var location = indexArr[0];
        if(location == "/" || location == "/index.php"){
            $("#navIndex").addClass("active");
        }
        else if(location == "/editMyInfo.php"){
            $("#navMyInfo").addClass("active");
        }
        else if(location == "/verificationUserList.php" || location == "/userList.php" || location == "/achievementList.php" || location == "/userInfoEdit.php" || location == "/userInfo.php"){
            $("#navUser").addClass("active");
        }
        else if(location == "/addNews.php" || location == "/newsList.php" || location == "/newsEdit.php"){
            $("#navNews").addClass("active");
        }
        else if(location == "/photoList.php" || location == "/fileList.php"){
            $("#navShare").addClass("active");
        }
        else if(location == "/addAchievement.php" || location == "/myAchievementList.php" || location == "/achievementEdit.php"){
            $("#navAchievement").addClass("active");
        }
    })


</script>
