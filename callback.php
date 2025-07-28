<?php
// oauth_system/php_demo/callback.php

require_once 'config.php';

// 1. 验证 state 参数
if (!isset($_GET['state']) || !isset($_SESSION['oauth2_state']) || $_GET['state'] !== $_SESSION['oauth2_state']) {
    // 清除 state 并显示错误
    unset($_SESSION['oauth2_state']);
    die('无效的 state 参数，可能存在 CSRF 攻击。');
}

// 2. 检查是否收到了 code
if (!isset($_GET['code'])) {
    if (isset($_GET['error'])) {
        die('授权失败: ' . htmlspecialchars($_GET['error']) . ' - ' . htmlspecialchars($_GET['error_description']));
    }
    die('未收到授权码 (code)。');
}

$code = $_GET['code'];

// 3. 使用 code 换取 access_token
$token_url = TOKEN_ENDPOINT;
$token_params = [
    'grant_type' => 'authorization_code',
    'code' => $code,
    'redirect_uri' => REDIRECT_URI,
    'client_id' => CLIENT_ID,
];

$ch = curl_init($token_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($token_params));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Accept: application/json'
]);

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curl_error = curl_error($ch);
curl_close($ch);

// 调试输出
echo "Token Endpoint Response Code: " . $http_code . "<br>";
echo "Token Endpoint Response Body: " . htmlspecialchars($response) . "<br>";
if ($curl_error) {
    echo "cURL Error: " . htmlspecialchars($curl_error) . "<br>";
}

if ($http_code !== 200) {
    die('无法获取 access_token。响应: ' . $response);
}

$token_data = json_decode($response, true);
if (!isset($token_data['access_token'])) {
    die('响应中未包含 access_token。');
}

$access_token = $token_data['access_token'];

// 4. 使用 access_token 获取用户信息
$user_info_url = USERINFO_ENDPOINT;

$ch = curl_init($user_info_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $access_token,
    'Accept: application/json'
]);

$user_response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($http_code !== 200) {
    die('无法获取用户信息。响应: ' . $user_response);
}

$user_info = json_decode($user_response, true);

// 5. 存储用户信息并重定向
$_SESSION['user_info'] = $user_info;
$_SESSION['access_token'] = $access_token;

header('Location: user_info.php');
exit;
