<?php
session_start();
include 'connect.php';
session_destroy();
echo "<script>document.location.href='[**URL**]/linkpage.html?logout'</script>";
?>
