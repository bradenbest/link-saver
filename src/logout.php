<?php
session_start();
session_destroy();
echo "<script>localStorage.removeItem('Link Saver');</script>";
header("Location:./");
die();
?>
