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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>第三方网站演示 - OAuth 2.0 集成</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            color: white;
            padding: 5rem 0;
            margin-bottom: 3rem;
        }
        .login-card {
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border-radius: 15px;
            overflow: hidden;
        }
        .btn-login {
            background: #6a11cb;
            border: none;
            padding: 12px 30px;
            font-size: 1.1rem;
            transition: all 0.3s;
        }
        .btn-login:hover {
            background: #2575fc;
            transform: translateY(-3px);
            box-shadow: 0 7px 14px rgba(50, 50, 93, 0.1), 0 3px 6px rgba(0, 0, 0, 0.08);
        }
        .feature-icon {
            width: 60px;
            height: 60px;
            background: rgba(106, 17, 203, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }
        footer {
            background: #f8f9fa;
            padding: 2rem 0;
            margin-top: 3rem;
        }
    </style>
</head>
<body>
    <!-- 导航栏 -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="https://via.placeholder.com/40" alt="Logo" class="me-2">
                第三方演示网站
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">首页</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">文档</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">支持</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- 主内容区 -->
    <div class="hero-section text-center">
        <div class="container">
            <h1 class="display-4 fw-bold">OAuth 2.0 集成演示</h1>
            <p class="lead">安全、标准的第三方登录解决方案</p>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="login-card card">
                    <div class="card-body p-5">
                        <h2 class="card-title text-center mb-4">欢迎访问</h2>
                        <p class="text-center mb-4">您尚未登录，请使用以下方式登录</p>
                        
                        <div class="d-grid">
                            <a href="<?php echo htmlspecialchars($authorization_url); ?>" class="btn btn-login btn-lg">
                                使用授权平台登录
                            </a>
                        </div>
                        
                        <div class="text-center mt-4">
                            <p class="text-muted">使用我们的OAuth 2.0服务安全登录</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mt-5">
            <div class="col-md-4 mb-4">
                <div class="text-center">
                    <div class="feature-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#6a11cb" viewBox="0 0 16 16">
                            <path d="M8 0C3.58 0 0 3.58 0 8s3.58 8 8 8 8-3.58 8-8-3.58-8-8-8zm3 12H5v-1h6v1zm0-2H5V9h6v1zm0-2H5V7h6v1z"/>
                        </svg>
                    </div>
                    <h4>安全可靠</h4>
                    <p>基于OAuth 2.0标准协议，保障用户数据安全</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="text-center">
                    <div class="feature-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#6a11cb" viewBox="0 0 16 16">
                            <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zM7 11.5a.5.5 0 0 1-1 0v-6a.5.5 0 0 1 1 0v6zm2 0a.5.5 0 0 1-1 0v-6a.5.5 0 0 1 1 0v6z"/>
                        </svg>
                    </div>
                    <h4>简单集成</h4>
                    <p>提供清晰的API文档和示例代码，快速对接</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="text-center">
                    <div class="feature-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#6a11cb" viewBox="0 0 16 16">
                            <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
                        </svg>
                    </div>
                    <h4>无缝体验</h4>
                    <p>用户无需重复注册，一键登录使用</p>
                </div>
            </div>
        </div>
    </div>

    <!-- 页脚 -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>第三方演示网站</h5>
                    <p>展示OAuth 2.0标准协议的集成实现</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0">&copy; <?php echo date('Y'); ?> 版权所有</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
