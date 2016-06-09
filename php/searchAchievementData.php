<?php
/**
 * Created by PhpStorm.
 * User: niqianye
 * Date: 16/5/27
 * Time: 21:30
 */
session_start();
include "util.php";

$achievementTitle = $_REQUEST["achievementTitle"];

$connection = createConnection();
$sql = "SELECT * FROM achievement WHERE isDeleted=0 AND title LIKE '%$achievementTitle%'";
$result = $connection -> query($sql);
if($result -> num_rows > 0){
    ?>
    <div class='container alert alert-success text-center' role='alert'>以下是成果标题带有 <span class="text-primary"><? echo $achievementTitle ?></span> 的信息</div>
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
