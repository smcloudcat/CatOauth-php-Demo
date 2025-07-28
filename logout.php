<?php
// oauth_system/php_demo/logout.php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// 清除所有 session 变量
$_SESSION = array();

// 如果存在 session cookie，也删除它
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 最后，销毁 session
session_destroy();

// 重定向到首页
header('Location: index.php');
exit;
?>
