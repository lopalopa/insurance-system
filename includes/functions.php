<?php
if (session_status() === PHP_SESSION_NONE) session_start();
function flash_set($key, $msg) {
    $_SESSION['_flash'][$key] = $msg;
}
function flash_get($key) {
    if (!isset($_SESSION['_flash'][$key])) return null;
    $v = $_SESSION['_flash'][$key];
    unset($_SESSION['_flash'][$key]);
    return $v;
}
