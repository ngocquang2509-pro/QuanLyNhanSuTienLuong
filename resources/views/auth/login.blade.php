<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - Hệ thống Quản lý Nhân sự</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(120deg, #2980b9, #8e44ad);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-header h1 {
            color: #2c3e50;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .login-header p {
            color: #7f8c8d;
            font-size: 16px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #2c3e50;
            font-size: 14px;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus {
            outline: none;
            border-color: #3498db;
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #666;
            font-size: 14px;
        }

        .forgot-password {
            color: #3498db;
            text-decoration: none;
            font-size: 14px;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        .login-btn {
            width: 100%;
            padding: 12px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .login-btn:hover {
            background-color: #2980b9;
        }

        .error-message {
            color: #e74c3c;
            font-size: 14px;
            margin-top: 5px;
            display: none;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            color: #7f8c8d;
            font-size: 12px;
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 20px;
                margin: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-header">
            <h1>Hệ Thống Quản Lý</h1>
            <p>Nhân Sự & Tiền Lương</p>
        </div>
        @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        <form id="loginForm" action="{{route('auth.check')}}" method="POST">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="username" name="email" placeholder="Nhập email đăng nhập">
                <div class="error-message" id="username-error"></div>
            </div>

            <div class="form-group">
                <label for="password">Mật khẩu</label>
                <input type="password" id="password" name="password" placeholder="Nhập mật khẩu">
                <div class="error-message" id="password-error"></div>
            </div>

            <div class="remember-forgot">
                <label class="remember-me">
                    <input type="checkbox" id="remember">
                    <span>Ghi nhớ đăng nhập</span>
                </label>
                <a href="{{route('auth.register')}}" class="forgot-password">Đăng ký tài khoản</a>
            </div>

            <button type="submit" class="login-btn">Đăng nhập</button>
        </form>

        <div class="footer">
            © 2025 HR Management System. All rights reserved.
        </div>
    </div>

    <script>
        function validateForm(event) {
            event.preventDefault();

            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            let isValid = true;

            // Reset error messages
            document.getElementById('username-error').style.display = 'none';
            document.getElementById('password-error').style.display = 'none';

            // Validate username
            if (!username) {
                document.getElementById('username-error').textContent = 'Vui lòng nhập tên đăng nhập';
                document.getElementById('username-error').style.display = 'block';
                isValid = false;
            }

            // Validate password
            if (!password) {
                document.getElementById('password-error').textContent = 'Vui lòng nhập mật khẩu';
                document.getElementById('password-error').style.display = 'block';
                isValid = false;
            } else if (password.length < 6) {
                document.getElementById('password-error').textContent = 'Mật khẩu phải có ít nhất 6 ký tự';
                document.getElementById('password-error').style.display = 'block';
                isValid = false;
            }

            if (isValid) {
                // Thực hiện đăng nhập ở đây
                console.log('Đăng nhập với:', {
                    username,
                    password,
                    remember: document.getElementById('remember').checked
                });
                // Có thể thêm code gọi API đăng nhập ở đây
            }

            return false;
        }

        // Kiểm tra và điền lại thông tin đăng nhập đã lưu (nếu có)
        window.onload = function() {
            const savedUsername = localStorage.getItem('username');
            if (savedUsername) {
                document.getElementById('username').value = savedUsername;
                document.getElementById('remember').checked = true;
            }
        }
    </script>
</body>

</html>