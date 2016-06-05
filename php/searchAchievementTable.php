<?php
/**
 * Created by PhpStorm.
 * User: Ray
 * Date: 16/6/5
 * Time: 15:06
 */
session_start();
include "util.php";

$currentPage = $_REQUEST["page"];

$connection = createConnection();
$sql = "SELECT * FROM achievement WHERE isDeleted=0 ORDER BY id DESC LIMIT ".(($currentPage-1)*10).",10";//(页数-1)*每页条数,每页条数
$result = $connection -> query($sql);
if($result -> num_rows > 0){
    ?>
    <div class='container alert alert-success text-center' role='alert'>以下是所有新闻的信息</div>
    <div class='container text-center'>
        <table class="table table-hover">
            <?php
            while ($row = $result -> fetch_assoc()){
                $id = $row["id"];
                $title = $row["title"];
                $createTime = $row["createTime"];
                ?>
                <tr id="achievement<? echo $id ?>" class="achievementTr" style="cursor: pointer">
                    <td><? echo $title ?></td>
                    <td style="text-align: right"><? echo $createTime ?></td>
                </tr>
                <?
            }
            ?>
        </table>
    </div>

    <?
}
else{
    echo "<div class='container alert alert-warning text-center' role='alert'>未查询到信息</div>";
}
closeConnection($connection);
?>
<script>
    $(".achievementTr").click(function () {
        var achievementId = this.id.replace(/achievement/,"");
        location.href = "achievementDetail.php?achievementId="+achievementId;
    })
</script>
