# CatOauth-php-Demo
小猫咪用户系统 OAuth 2.0 集成演示

## 项目简介
这是一个使用 PHP 实现的 OAuth 2.0 客户端演示项目，展示了如何与授权服务器进行集成，实现第三方登录功能。

## 对接参数说明
在 `config.php` 文件中配置以下参数：

| 参数名 | 描述 | 示例值 |
|--------|------|--------|
| `CLIENT_ID` | 应用ID（随意填写，用于让用户自动你应用名称） | `php-demo-app` |
| `REDIRECT_URI` | 回调地址 | `http://localhost/callback.php` |
| `SCOPE` | 请求的权限范围 | `openid profile email` |
| `AUTHORIZATION_ENDPOINT` | 授权端点 | `https://oauth.lwcat.cn/authorize` |
| `TOKEN_ENDPOINT` | 令牌端点 | `https://oauth.lwcat.cn/token` |
| `USERINFO_ENDPOINT` | 用户信息端点 | `https://oauth.lwcat.cn/userinfo` |

## API 接口文档

### 1. 回调接口 - `/callback.php`
- **功能**：处理授权服务器返回的授权码，换取访问令牌
- **请求参数**：
  - `code`：授权码
  - `state`：防止CSRF攻击的状态参数
- **响应**：
  - 成功：存储用户信息到session，重定向到用户信息页
  - 失败：返回错误信息

### 2. 用户信息接口 - `/user_info.php`
- **功能**：展示当前登录用户的个人信息
- **访问条件**：用户已登录（session中有用户信息）
- **响应**：JSON格式的用户信息

### 3. 退出登录接口 - `/logout.php`
- **功能**：清除用户session，退出登录
- **响应**：重定向到首页

## 使用示例

### 1. 配置项目
1. 复制 `config.sample.php` 为 `config.php`
2. 修改 `config.php` 中的配置参数

### 2. 运行项目
```bash
# 启动PHP内置服务器
php -S localhost:8000
```

### 3. 访问应用
1. 打开浏览器访问 `http://localhost:8000`
2. 点击"使用授权平台登录"按钮
3. 完成授权流程后，将显示用户信息

## 注意事项
1. 确保 `session_start()` 在所有需要session的页面顶部调用
2. 生产环境应使用HTTPS
3. 妥善保管 `CLIENT_SECRET`，不要泄露
4. 定期更新state参数防止CSRF攻击
5. 验证ID Token签名确保安全性
