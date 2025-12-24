<?php
session_start();
session_destroy();
header("Location: /ShoeZilla/index.php");
exit();
?>
