<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            min-height: 100vh;
            background: #4285f4;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            background: white;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .login-container:hover {
            transform: translateY(-5px);
        }

        .login-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .logo {
            width: 60px;
            height: 60px;
            background: #4285f4;
            border-radius: 50%;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
        }

        .login-title {
            font-size: 28px;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }

        .login-subtitle {
            color: #666;
            font-size: 16px;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            color: #333;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 8px;
        }

        .input-wrapper {
            position: relative;
        }

        .form-input {
            width: 100%;
            padding: 14px 16px 14px 45px;
            border: 2px solid #e1e5e9;
            border-radius: 8px;
            font-size: 16px;
            color: #333;
            background: #fff;
            transition: all 0.3s ease;
            outline: none;
        }

        .form-input:focus {
            border-color: #4285f4;
            box-shadow: 0 0 0 3px rgba(66, 133, 244, 0.1);
        }

        .form-input::placeholder {
            color: #999;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .form-input:focus + .input-icon {
            color: #4285f4;
        }

        .password-toggle {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #999;
            cursor: pointer;
            font-size: 16px;
            padding: 4px;
            transition: all 0.3s ease;
        }

        .password-toggle:hover {
            color: #4285f4;
        }

        .checkbox-wrapper {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 32px;
        }

        .checkbox-container {
            position: relative;
        }

        .checkbox-input {
            appearance: none;
            width: 20px;
            height: 20px;
            border: 2px solid #e1e5e9;
            border-radius: 4px;
            background: white;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .checkbox-input:checked {
            background: #4285f4;
            border-color: #4285f4;
        }

        .checkbox-input:checked::after {
            content: '✓';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 12px;
            font-weight: bold;
        }

        .checkbox-label {
            color: #666;
            font-size: 14px;
            cursor: pointer;
        }

        .login-button {
            width: 100%;
            padding: 16px;
            background: #4285f4;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 16px;
        }

        .login-button:hover {
            background: #3367d6;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(66, 133, 244, 0.3);
        }

        .login-button:active {
            transform: translateY(0);
        }

        .login-button:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .error-message {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 20px;
            display: none;
        }

        .success-message {
            background: #f0f9ff;
            border: 1px solid #bae6fd;
            color: #0369a1;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 14px;
            margin-top: 16px;
            text-align: center;
        }

        .forgot-password {
            text-align: center;
            margin-top: 16px;
        }

        .forgot-password a {
            color: #4285f4;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .forgot-password a:hover {
            text-decoration: underline;
            color: #3367d6;
        }

        .loading-spinner {
            display: none;
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s linear infinite;
            margin-right: 8px;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .button-content {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 32px 24px;
                margin: 16px;
            }

            .login-title {
                font-size: 24px;
            }
        }

        /* Smooth animations */
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="login-container fade-in">
        <div class="login-header">
            <div class="logo">
                <i class="fas fa-user"></i>
            </div>
            <h1 class="login-title">Selamat Datang</h1>
            <p class="login-subtitle">Silakan masuk ke akun Anda</p>
        </div>

        <div class="error-message" id="errorMessage">
            <i class="fas fa-exclamation-circle"></i> Invalid username or password
        </div>

        <form method="POST" action="{{ route('login.process') }}">
            @csrf
            <div class="form-group">
                <label for="name" class="form-label">Nama</label>
                <div class="input-wrapper">
                    <input
                        type="text"
                        class="form-input"
                        id="name"
                        name="name"
                        placeholder="Masukkan Nama Kamu"
                        required
                    >
                    <i class="fas fa-user input-icon"></i>
                </div>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <div class="input-wrapper">
                    <input
                        type="password"
                        class="form-input"
                        id="password"
                        name="password"
                        placeholder="Masukkan Password Kamu"
                        required
                    >
                    <i class="fas fa-lock input-icon"></i>
                    <button type="button" class="password-toggle" onclick="togglePassword()">
                        <i class="fas fa-eye" id="toggleIcon"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="login-button" id="loginBtn">
                <div class="button-content">
                    <div class="loading-spinner" id="loadingSpinner"></div>
                    <span id="buttonText">Masuk</span>
                </div>
            </button>
        </form>
        <div id="messageContainer"></div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.className = 'fas fa-eye-slash';
            } else {
                passwordInput.type = 'password';
                toggleIcon.className = 'fas fa-eye';
            }
        }

        function showForgotMessage() {
            const messageContainer = document.getElementById('messageContainer');
            messageContainer.innerHTML = `
                <div class="success-message">
                    <i class="fas fa-info-circle"></i>
                    Password reset link would be sent to your email
                </div>
            `;
        }

        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const loadingSpinner = document.getElementById('loadingSpinner');
            const buttonText = document.getElementById('buttonText');
            const loginBtn = document.getElementById('loginBtn');
            const errorMessage = document.getElementById('errorMessage');
            const messageContainer = document.getElementById('messageContainer');

            // Reset messages
            errorMessage.style.display = 'none';
            messageContainer.innerHTML = '';

            // Show loading state
            loadingSpinner.style.display = 'inline-block';
            buttonText.textContent = 'Signing In...';
            loginBtn.disabled = true;

            // Simulate login process
            setTimeout(function() {
                const name = document.getElementById('name').value;
                const password = document.getElementById('password').value;
            }, 1500);
        });

        // Add shake animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes shake {
                0%, 100% { transform: translateX(0) translateY(-5px); }
                25% { transform: translateX(-5px) translateY(-5px); }
                75% { transform: translateX(5px) translateY(-5px); }
            }
        `;
        document.head.appendChild(style);

        // Add focus animations
        document.querySelectorAll('.form-input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
            });

            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });
    </script>
</body>
</html>