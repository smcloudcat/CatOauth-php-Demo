<?php
// oauth_system/php_demo/config.php

// 启动 session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// 定义常量
// 客户端配置
define('CLIENT_ID', 'php-demo-app'); // 客户端ID，现在可以是任何描述性字符串
define('REDIRECT_URI', 'https://demo.lwcat.cn/callback.php'); // 你的回调地址

// 授权服务器的端点 URL
define('AUTHORIZATION_ENDPOINT', 'https://oauth.lwcat.cn/oauth/authorize');
define('TOKEN_ENDPOINT', 'https://oauth.lwcat.cn/oauth/token');
define('USERINFO_ENDPOINT', 'https://oauth.lwcat.cn/api/me');

// 请求的权限范围
define('SCOPE', 'profile email avatar username');
?>