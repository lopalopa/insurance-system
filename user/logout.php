<?php
session_start();
$_SESSION = [];
session_destroy();
header('Location: /insurance-system-full/user/login.php');
exit;
