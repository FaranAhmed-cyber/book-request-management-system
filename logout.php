<?php
// Session khatam karke login page par wapas bhejna
session_start();
session_destroy();
header("Location: user/login.php");
exit();
?>