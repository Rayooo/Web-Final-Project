<?php
/**
 * Created by PhpStorm.
 * User: niqianye
 * Date: 16/5/26
 * Time: 22:56
 */
session_start();
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>主页</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <style>
        .commentAvatarImage{
            width:64px;
            height:64px;
            line-height: 0;
            display: inline-block;
            border-radius: 50%;	
            -moz-border-radius: 50%;
            -webkit-border-radius: 50%;
        }
        .thumbnail{
            border: 0;
        }
        canvas {
            display: block;
            vertical-align: bottom;
        }
        #particles-js {
            position:fixed;
            z-index: -10;
            width: 100%;
            height: 100%;
            background-color: #2aabd2;
            background-repeat: no-repeat;
            background-size: cover;
            background-position: 50% 50%;
        }
        #jumbotron{
            padding: 0;
            position: relative;
        }
        #welcome{
            text-align: right;
            position: absolute;
            top:10%;
            right: 5%;
        }

    </style>
</head>

<body>

<div id="particles-js"></div>
<script src="../js/particles.js"></script>
<script src="../js/particlesSetting.js"></script>
<?php include "navbar.php"; ?>

<div class="jumbotron" id="jumbotron">
    <div class="container" id="welcome">
        <h1>Welcome</h1>
        <a href="#newsA" style="font-size: 25px;color: #a6e22d">新闻</a><br>
        <a href="#achievementA" style="font-size: 25px;color: #a6e22d">成果展示</a><br>
        <a href="#introductionA" style="font-size: 25px;color: #a6e22d">个人介绍</a><br>
    </div>
    <img src="../image/indexBackground.jpg" class="img-responsive">
</div>


<div class="container">
    <div class="row" id="newsA">
        <div class="col-sm-12 col-md-12">
            <div class="thumbnail" style="background-color: rgba(255, 255, 255, 0.6);">
                <div class="caption">
                    <h3>新闻展示 <a class="btn btn-info" style="float: right" href="searchNews.php">所有新闻</a></h3>

                    <div class="list-group" style="margin-top: 2%">
                        <?php
                        $connection = createConnection();
                        $sql = "SELECT id,title,createTime FROM news WHERE isDeleted=0 ORDER BY id DESC LIMIT 10";
                        $result = $connection -> query($sql);
                        if($result -> num_rows > 0){
                            while($row = $result->fetch_assoc()){
                                ?>
                                <a href="newsDetail.php?newsId=<?php echo $row["id"] ?>" class="list-group-item"><?php echo $row["title"] ?><span style="float: right"><?php echo $row["createTime"] ?></span></a>
                                <?php
                            }
                        }
                        closeConnection($connection);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row" id="achievementA">
        <div class="col-sm-12 col-md-12">
            <div class="thumbnail"  style="background-color: rgba(255, 255, 255, 0.6);">
                <div class="caption">
                    <h3>成果展示 <a class="btn btn-info" style="float: right" href="searchAchievement.php">所有成果</a></h3>

                    <div class="list-group" style="margin-top: 2%" >
                        <?php
                        $connection = createConnection();
                        $sql = "SELECT id,title,createTime FROM achievement WHERE isDeleted=0 ORDER BY id DESC LIMIT 10";
                        $result = $connection->query($sql);
                        if($result -> num_rows > 0){
                            while ($row = $result->fetch_assoc()){
                                ?>
                                <a href="achievementDetail.php?achievementId=<?php echo $row["id"] ?>" class="list-group-item"><?php echo $row["title"] ?><span style="float: right"><?php echo $row["createTime"] ?></span></a>
                                <?php
                            }
                        }
                        closeConnection($connection);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="row" id="introductionA">
        <div class="col-sm-12 col-md-12">
            <div class="thumbnail" style="background-color: rgba(255, 255, 255, 0.9);">
                <div class="caption">
                    <h3>活跃成员(按发布成果数排序)</h3>
                    <?php
                    //按照成员发布成果数量排序
                    $countActiveUser = 0;
                    $connection = createConnection();
                    $userConnection = createConnection();

                    $sql = "SELECT userId,count(id) FROM achievement WHERE isDeleted=0 GROUP BY userId ORDER BY count(id) DESC";
                    $result = $connection->query($sql);
                    if($result -> num_rows > 0){
                        while ($row = $result -> fetch_assoc()){
                            $userSql = "SELECT name,headImage,introduction FROM user WHERE isDeleted=0 AND isManager=0 AND isPassed=1 AND id=".$row["userId"];
                            $userResult = $userConnection->query($userSql);
                            if($userResult -> num_rows > 0){
                                $userRow = $userResult -> fetch_assoc();
                                $countActiveUser++;
                                if($countActiveUser > 10)
                                    break;
                                ?>
                                <div class="media" style="margin-top: 3%">
                                    <div class="media-left media-middle">
                                        <img class="media-object commentAvatarImage" src="<?php echo $userRow["headImage"] ?>">
                                    </div>
                                    <div class="media-body">
                                        <h4 class="media-heading"><?php echo $userRow["name"] ?></h4>
                                        <h5>发表成果数:<?php echo $row["count(id)"]?></h5>
                                        <?php echo $userRow["introduction"] == null? "":$userRow["introduction"]?>
                                    </div>
                                </div>
                    <?php
                            }
                        }
                    }
                    closeConnection($userConnection);
                    closeConnection($connection);
                    ?>
                </div>
            </div>
        </div>
    </div>

</div>

</body>
</html>
