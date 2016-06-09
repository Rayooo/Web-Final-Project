<?php
/**
 * Created by PhpStorm.
 * User: niqianye
 * Date: 16/5/20
 * Time: 21:30
 */
session_start();
session_destroy();
echo "<script>location.href='index.php'</script>";
?>