<?php
// oauth_system/php_demo/index.php

require_once 'config.php';

// 检查 session 中是否已存储用户信息
if (isset($_SESSION['user_info'])) {
    // 如果用户信息存在，重定向到用户信息展示页面
    header('Location: user_info.php');
    exit;
}

// 如果 session 中没有用户信息，则显示登录链接

// 生成 state 参数，用于防止 CSRF 攻击
$state = bin2hex(random_bytes(16));
$_SESSION['oauth2_state'] = $state;

// 构建授权 URL
$authorization_url = AUTHORIZATION_ENDPOINT . '?' . http_build_query([
    'response_type' => 'code',
    'client_id' => CLIENT_ID,
    'redirect_uri' => REDIRECT_URI,
    'scope' => SCOPE,
    'state' => $state,
]);
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>模拟第三方网站</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; padding: 20px; }
        a { color: #007bff; text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <h1>欢迎来到模拟第三方网站</h1>
    <p>您尚未登录。</p>
    <p>
        <a href="<?php echo htmlspecialchars($authorization_url); ?>">
            使用我们的授权平台登录
        </a>
    </p>
</body>
</html>
