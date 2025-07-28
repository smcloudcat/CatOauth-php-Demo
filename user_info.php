<?php
// oauth_system/php_demo/user_info.php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// 检查用户是否已登录 (即 session 中是否存在用户信息)
if (!isset($_SESSION['user_info'])) {
    header('Location: index.php');
    exit;
}

$userInfo = $_SESSION['user_info'];
$accessToken = $_SESSION['access_token'];

?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>用户信息 - 第三方应用</title>
    <style>
        body { font-family: sans-serif; line-height: 1.6; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; border: 1px solid #ccc; padding: 20px; border-radius: 5px; }
        .avatar { max-width: 100px; border-radius: 50%; }
        pre { background-color: #f4f4f4; padding: 10px; border-radius: 3px; white-space: pre-wrap; word-wrap: break-word; }
        a { color: #007bff; text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <h1>欢迎, <?php echo htmlspecialchars($userInfo['nickname'] ?? '用户'); ?>!</h1>
        <p>您已成功通过授权平台登录。</p>
        
        <h2>您的信息:</h2>
        <?php if (isset($userInfo['avatar'])): ?>
            <img src="<?php echo htmlspecialchars($userInfo['avatar']); ?>" alt="用户头像" class="avatar">
        <?php endif; ?>
        <ul>
            <li><strong>用户ID:</strong> <?php echo htmlspecialchars($userInfo['id']); ?></li>
            <li><strong>昵称:</strong> <?php echo htmlspecialchars($userInfo['nickname']); ?></li>
            <li><strong>邮箱:</strong> <?php echo htmlspecialchars($userInfo['email']); ?></li>
        </ul>

        <h2>收到的完整用户信息:</h2>
        <pre><?php echo json_encode($userInfo, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE); ?></pre>

        <h2>Access Token:</h2>
        <pre><?php echo htmlspecialchars($accessToken); ?></pre>

        <p><a href="logout.php">退出登录</a></p>
    </div>
</body>
</html>
