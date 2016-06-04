<?php
/**
 * Created by PhpStorm.
 * User: Ray
 * Date: 16/6/4
 * Time: 11:11
 */
session_start();
include "util.php";
?>
<style>
    #editInfoForm{
        max-width: 550px;
        margin: 0 auto;
    }
    #headImageDiv{
        width: 80%;
        margin: auto;
        margin-bottom: 5%;
    }
    #headImageDiv2{
        width: 80%;
        margin-left: 25%;
    }
    #preview{
        width:200px;
        height:200px;
        line-height: 0;
        display: inline-block;
        border-radius: 50%;
        -moz-border-radius: 50%;
        -webkit-border-radius: 50%;
        transition: linear 0.25s;
    }
</style>
<?php
$userId = $_REQUEST["userId"];
$userName = "";
$headImage = "";
$mobile = "";
$sex = 1;
$name = "";
$introduction = "";
$createTime = "";

$connection = createConnection();
$sql = "SELECT * FROM user WHERE id=".$userId;
$result = $connection->query($sql);
if($result -> num_rows){
    $row = $result -> fetch_assoc();
    $userId = $row["id"];
    $userName = $row["userName"];
    $headImage = $row["headImage"];
    $mobile = $row["mobile"];
    $sex = $row["sex"];
    $name = $row["name"];
    $introduction = $row["introduction"];
    $createTime = $row["createTime"];
}
closeConnection($connection);
?>

<form class="form-register form-horizontal" id="editInfoForm" >
    <h2 class="form-signin-heading text-center">用户信息</h2>

    <div class="form-group"  id="headImageDiv">
        <div class="col-md-6" id="headImageDiv2">
            <img id="preview" src="<? echo $headImage?>" alt="...">
        </div>
    </div>

    <div class="form-group">
        <label for="userId" class="col-md-3 control-label">用户ID</label>
        <div class= "col-md-8">
            <input type="text" id="userId" name="userId" class="form-control" value="<? echo $userId?>" readonly>
        </div>
    </div>

    <div class="form-group">
        <label for="userName" class="col-md-3 control-label">用户名</label>
        <div class= "col-md-8">
            <input type="text" id="userName" name="userName" class="form-control" value="<? echo $userName?>" readonly>
        </div>
    </div>

    <div class="form-group">
        <label for="name" class="col-md-3 control-label">真实姓名</label>
        <div class= "col-md-8">
            <input type="text" id="name" name="name" class="form-control" value="<? echo $name?>" readonly>
        </div>
    </div>

    <div class="form-group">
        <label for="mobile" class="col-md-3 control-label">手机号</label>
        <div class= "col-md-8">
            <input type="text" id="mobile" name="mobile" class="form-control" value="<? echo $mobile==null? "":$mobile?>" readonly>
        </div>
    </div>

    <div class="form-group">
        <label for="sex" class="col-md-3 control-label">性别</label>
        <div class= "col-md-8">
            <input type="text" id="sex" name="sex" class="form-control" value="<? echo $sex==1?"男":"女"?>" readonly>
        </div>
    </div>

    <div class="form-group">
        <label for="createTime" class="col-md-3 control-label">注册时间</label>
        <div class= "col-md-8">
            <input type="text" id="createTime" name="createTime" class="form-control" value="<? echo $createTime?>" readonly>
        </div>
    </div>

    <div class="form-group">
        <label for="introduction" class="col-md-3 control-label">自我介绍</label>
        <div class= "col-md-8">
            <textarea type="text" id="introduction" name="introduction" class="form-control" readonly><? echo $introduction==null? "":$introduction?></textarea>
        </div>
    </div>

</form>










