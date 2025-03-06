<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký - Hệ thống Quản lý Nhân sự</title>
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

        .register-container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 500px;
            margin: 20px;
        }

        .register-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .register-header h1 {
            color: #2c3e50;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .register-header p {
            color: #7f8c8d;
            font-size: 16px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-row .form-group {
            flex: 1;
            margin-bottom: 0;
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

        .error-message {
            color: #e74c3c;
            font-size: 14px;
            margin-top: 5px;
            display: none;
        }

        .register-btn {
            width: 100%;
            padding: 12px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 20px;
        }

        .register-btn:hover {
            background-color: #2980b9;
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
            color: #7f8c8d;
            font-size: 14px;
        }

        .login-link a {
            color: #3498db;
            text-decoration: none;
            font-weight: bold;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            color: #7f8c8d;
            font-size: 12px;
        }

        @media (max-width: 600px) {
            .form-row {
                flex-direction: column;
                gap: 0;
            }

            .register-container {
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="register-container">
        <div class="register-header">
            <h1>Đăng Ký Tài Khoản</h1>
            <p>Hệ Thống Quản Lý Nhân Sự & Tiền Lương</p>
        </div>

        <form id="registerForm" action="{{route('auth.store')}}" method="post">
            @csrf
            <div class="form-row">
                <div class="form-group">
                    <label for="firstName">Họ</label>
                    <input type="text" id="firstName" name="firstName" placeholder="Nhập họ">
                    <div class="error-message" id="firstName-error"></div>
                </div>

                <div class="form-group">
                    <label for="lastName">Tên</label>
                    <input type="text" id="lastName" name="name" placeholder="Nhập tên">
                    <div class="error-message" id="lastName-error"></div>
                </div>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Nhập email">
                <div class="error-message" id="email-error"></div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="password">Mật khẩu</label>
                    <input type="password" id="password" name="password" placeholder="Nhập mật khẩu">
                    <div class="error-message" id="password-error"></div>
                </div>

                <div class="form-group">
                    <label for="confirmPassword">Xác nhận mật khẩu</label>
                    <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Nhập lại mật khẩu">
                    <div class="error-message" id="confirmPassword-error"></div>
                </div>
            </div>

            <button type="submit" class="register-btn">Đăng ký</button>
        </form>

        <div class="login-link">
            Đã có tài khoản? <a href="{{route('login')}}">Đăng nhập ngay</a>
        </div>

        <div class="footer">
            © 2025 HR Management System. All rights reserved.
        </div>
    </div>

    <script>
        function validateForm(event) {
            event.preventDefault();

            const firstName = document.getElementById('firstName').value;
            const lastName = document.getElementById('lastName').value;
            const email = document.getElementById('email').value;
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;

            let isValid = true;

            // Reset all error messages
            document.querySelectorAll('.error-message').forEach(error => {
                error.style.display = 'none';
            });

            // Validate first name
            if (!firstName) {
                showError('firstName', 'Vui lòng nhập họ');
                isValid = false;
            }

            // Validate last name
            if (!lastName) {
                showError('lastName', 'Vui lòng nhập tên');
                isValid = false;
            }

            // Validate email
            if (!email) {
                showError('email', 'Vui lòng nhập email');
                isValid = false;
            } else if (!isValidEmail(email)) {
                showError('email', 'Email không hợp lệ');
                isValid = false;
            }

            // Validate username
            if (!username) {
                showError('username', 'Vui lòng nhập tên đăng nhập');
                isValid = false;
            } else if (username.length < 4) {
                showError('username', 'Tên đăng nhập phải có ít nhất 4 ký tự');
                isValid = false;
            }

            // Validate password
            if (!password) {
                showError('password', 'Vui lòng nhập mật khẩu');
                isValid = false;
            } else if (password.length < 6) {
                showError('password', 'Mật khẩu phải có ít nhất 6 ký tự');
                isValid = false;
            }

            // Validate confirm password
            if (!confirmPassword) {
                showError('confirmPassword', 'Vui lòng xác nhận mật khẩu');
                isValid = false;
            } else if (password !== confirmPassword) {
                showError('confirmPassword', 'Mật khẩu không khớp');
                isValid = false;
            }

            if (isValid) {
                // Submit form data
                console.log('Form submitted:', {
                    firstName,
                    lastName,
                    email,
                    username,
                    password
                });
                // Có thể thêm code gọi API đăng ký ở đây
            }

            return false;
        }

        function showError(fieldId, message) {
            const errorElement = document.getElementById(`${fieldId}-error`);
            errorElement.textContent = message;
            errorElement.style.display = 'block';
        }

        function isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }
    </script>
</body>

</html>