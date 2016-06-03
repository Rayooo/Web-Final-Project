<?php
/**
 * Created by PhpStorm.
 * User: Ray
 * Date: 16/6/3
 * Time: 20:38
 */
session_start();
session_destroy();
echo "<script>location.href='index.php'</script>";
?>