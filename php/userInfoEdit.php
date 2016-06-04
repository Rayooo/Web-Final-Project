<?php
/**
 * Created by PhpStorm.
 * User: Ray
 * Date: 16/6/4
 * Time: 11:26
 */
session_start();
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>修改用户信息</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/vue.js"></script>
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
        #buttonDiv{
            margin-top: 5%;
            margin-bottom: 20%;
        }
        #preview{
            width:200px;
            height:200px;
            line-height: 0;	/* remove line-height */
            display: inline-block;	/* circle wraps image */
            border-radius: 50%;	/* relative value */
            -moz-border-radius: 50%;
            -webkit-border-radius: 50%;
            transition: linear 0.25s;
        }
    </style>
</head>
<body>
<?php
include "navbar.php";
confirmationManager();
$userId = $_REQUEST["id"];
$userName = "";
$password = "";
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
    $password = $row["password"];
    $headImage = $row["headImage"];
    $mobile = $row["mobile"];
    $sex = $row["sex"];
    $name = $row["name"];
    $introduction = $row["introduction"];
    $createTime = $row["createTime"];
}
closeConnection($connection);
?>

<div class="container">
    <form class="form-register form-horizontal" id="editInfoForm" onsubmit="return check()" action="editInfoPost.php" method="post" enctype="multipart/form-data">
        <h2 class="form-signin-heading text-center">编辑信息</h2>

        <div class="form-group"  id="headImageDiv">
            <div class="col-md-6" id="headImageDiv2">
                <img id="preview" src="../<? echo $headImage ?>">
                <div class="caption">
                    <input type="file" accept="image/*" name="image" id="uploadImage">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="userId" class="col-md-3 control-label">用户ID</label>
            <div class= "col-md-8">
                <input type="text" id="userId" name="userId" class="form-control" placeholder="用户ID" value="<? echo $userId ?>" readonly>
            </div>
        </div>

        <div class="form-group">
            <label for="userName" class="col-md-3 control-label">用户名(必填)</label>
            <div class= "col-md-8" v-bind:class="{'has-success':isOkUserName,'has-error':isErrorUserName}">
                <input type="text" id="userName" name="userName" v-model="userName" class="form-control" placeholder="用户名"  required autofocus>
                <span class="glyphicon glyphicon-ok form-control-feedback" style="margin-right: 10px" v-show="isOkUserName"></span>
                <span class="glyphicon glyphicon-remove form-control-feedback" style="margin-right: 10px" v-show="isErrorUserName"></span>
            </div>
        </div>

        <div class="form-group">
            <label for="password" class="col-md-3 control-label">密码(必填)</label>
            <div class= "col-md-8" v-bind:class="{'has-success':isOkPassword,'has-error':isErrorPassword}">
                <input type="password" id="password" name="password" v-model="password" class="form-control" placeholder="密码" required>
                <span class="glyphicon glyphicon-ok form-control-feedback" style="margin-right: 10px" v-show="isOkPassword"></span>
                <span class="glyphicon glyphicon-remove form-control-feedback" style="margin-right: 10px" v-show="isErrorPassword"></span>
            </div>
        </div>

        <div class="form-group">
            <label for="password2" class="col-md-3 control-label">重复密码(必填)</label>
            <div class= "col-md-8" v-bind:class="{'has-success':isOkPassword2,'has-error':isErrorPassword2}">
                <input type="password" id="password2" name="password2" v-model="password2" class="form-control" placeholder="密码" required>
                <span class="glyphicon glyphicon-ok form-control-feedback" style="margin-right: 10px" v-show="isOkPassword2"></span>
                <span class="glyphicon glyphicon-remove form-control-feedback" style="margin-right: 10px" v-show="isErrorPassword2"></span>
            </div>
        </div>

        <div class="form-group">
            <label for="name" class="col-md-3 control-label">真实姓名(必填)</label>
            <div class= "col-md-8" v-bind:class="{'has-success':isOkName,'has-error':isErrorName}">
                <input type="text" id="name" name="name" v-model="name" class="form-control" placeholder="真实姓名" required>
                <span class="glyphicon glyphicon-ok form-control-feedback" style="margin-right: 10px" v-show="isOkName"></span>
                <span class="glyphicon glyphicon-remove form-control-feedback" style="margin-right: 10px" v-show="isErrorName"></span>
            </div>
        </div>

        <div class="form-group">
            <label for="mobile" class="col-md-3 control-label">手机号</label>
            <div class= "col-md-8" v-bind:class="{'has-success':isOkMobile,'has-error':isErrorMobile}">
                <input type="text" id="mobile" name="mobile" v-model="mobile" class="form-control" placeholder="手机号">
                <span class="glyphicon glyphicon-ok form-control-feedback" style="margin-right: 10px" v-show="isOkMobile"></span>
                <span class="glyphicon glyphicon-remove form-control-feedback" style="margin-right: 10px" v-show="isErrorMobile"></span>
            </div>
        </div>

        <div class="form-group">
            <label for="sex" class="col-md-3 control-label">性别</label>
            <div class= "col-md-8">
                <select id="sex" name="sex" class="form-control">
                    <?php
                    if($sex == 1){
                        echo "<option value='1' selected>男</option>";
                        echo "<option value='0'>女</option>";
                    }else if($sex == 0){
                        echo "<option value='1'>男</option>";
                        echo "<option value='0' selected>女</option>";
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="introduction" class="col-md-3 control-label">自我介绍</label>
            <div class= "col-md-8">
                <textarea type="text" id="introduction" name="introduction" class="form-control" placeholder="自我介绍"><? echo $introduction==null? "":$introduction ?></textarea>
            </div>
        </div>

        <div class="text-center" id="buttonDiv">
            <button class="btn btn-lg btn-primary" type="submit">确定</button>
            <a class="btn btn-lg btn-default" type="button" onclick="window.close();">取消</a>
        </div>

    </form>
</div>


</body>
</html>

<script>
    function preview(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#preview').attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("body").on("change", "#uploadImage", function (){
        preview(this);
    });

    function check() {
        if(editInfoFormData.isOkUserName && editInfoFormData.isOkPassword2 && editInfoFormData.isOkName && (editInfoFormData.isOkMobile || editInfoFormData.mobile.length == 0)){
            return true;
        }else{
            swal("表单信息有误,请重新更改后重新提交", "请重新输入", "warning");
            return false;
        }
    }

    var editInfoFormData = new Vue({
        el: "#editInfoForm",
        data: {
            userName:"<? echo $userName ?>",
            password:"<? echo $password ?>",
            password2:"<? echo $password ?>",
            name:"<? echo $name ?>",
            mobile:"<? echo $mobile==null? "":$mobile ?>",
            duplicationUserName: false
        },
        computed: {
            isOkUserName: function () {
                return this.userName.length > 7 && this.userName.length < 15 && !this.duplicationUserName;
            },
            isErrorUserName: function () {
                return (this.userName.length >= 1 && this.userName.length <= 7) || this.userName.length >= 15 || this.duplicationUserName;
            },
            isOkPassword: function () {
                return this.password.length > 7 && this.password.length < 15;
            },
            isErrorPassword: function () {
                return (this.password.length >= 1 && this.password.length <= 7) || this.password.length >= 15;
            },
            isOkPassword2: function () {
                return this.password == this.password2 && this.password2.length > 7;
            },
            isErrorPassword2: function () {
                return this.password2.length >= 1 && (this.password != this.password2 ||this.isErrorPassword);
            },
            isOkName : function () {
                return this.name.length > 1 && this.name.length < 15;
            },
            isErrorName: function () {
                return this.name.length == 1 || this.name.length >= 15;
            },
            isOkMobile: function () {
                return  this.mobile.length >= 1 && /^1\d{10}$/.test(this.mobile);
            },
            isErrorMobile: function () {
                return this.mobile.length >= 1 && !this.isOkMobile;
            }
        }
    });

    editInfoFormData.$watch('userName',function (val) {
        if(val.length > 7 && val.length < 15){
            $.post("duplicationUserName.php",{userName:val},function (data) {
                editInfoFormData.duplicationUserName = data == "error";
            })
        }
    })


</script>

