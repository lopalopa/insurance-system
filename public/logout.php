<?php
session_start();
$_SESSION = [];
session_destroy();
header('Location: /insurance-system-full/public/login.php');
exit;
