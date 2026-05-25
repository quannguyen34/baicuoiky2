<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký - TravelGo</title>
    <!-- Thư viện Icon & Font -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Nunito', sans-serif; }
        body { background-color: #f4f7f6; color: #333; display: flex; justify-content: center; align-items: center; min-height: 100vh; padding: 20px 0; }
        
        .login-container { width: 100%; max-width: 450px; padding: 20px; }
        
        /* LOGO */
        .logo-area { text-align: center; margin-bottom: 30px; }
        .logo-area a { font-size: 36px; font-weight: 800; color: #ff4757; text-decoration: none; display: flex; justify-content: center; align-items: center; gap: 10px; transition: 0.3s; }
        .logo-area a:hover { transform: scale(1.05); }
        
        /* KHUNG ĐĂNG KÝ */
        .login-card { background: white; padding: 40px 30px; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); }
        .login-title { text-align: center; font-size: 20px; font-weight: 700; color: #2f3542; margin-bottom: 25px; }
        
        /* FORM INPUT */
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-weight: 700; margin-bottom: 8px; color: #2f3542; font-size: 14px; }
        .form-control { width: 100%; padding: 12px 15px; border: 1px solid #dfe4ea; border-radius: 8px; font-size: 16px; transition: all 0.3s; background: #f8f9fa; }
        .form-control:focus { outline: none; border-color: #ff4757; background: white; box-shadow: 0 0 0 3px rgba(255, 71, 87, 0.1); }
        
        /* NÚT ĐĂNG KÝ */
        .btn-login { width: 100%; background: #ff4757; color: white; border: none; padding: 14px; border-radius: 8px; font-size: 16px; font-weight: 800; cursor: pointer; transition: 0.3s; text-transform: uppercase; letter-spacing: 1px; margin-top: 10px; }
        .btn-login:hover { background: #e84150; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(255, 71, 87, 0.3); }

        /* NÚT QUAY LẠI TRANG CHỦ */
        .back-home { display: block; text-align: center; margin-top: 25px; color: #747d8c; text-decoration: none; font-weight: 700; font-size: 14px; transition: 0.3s; }
        .back-home:hover { color: #ff4757; }

        /* BÁO LỖI (NẾU CÓ) */
        .text-red-600 { color: #ff4757; font-size: 13px; margin-top: 5px; font-weight: 600; list-style: none; }
    </style>
</head>
<body>

    <div class="login-container">
        <!-- Logo TravelGo -->
        <div class="logo-area">
            <a href="{{ route('home') }}"><i class="fas fa-paper-plane"></i> TravelGo</a>
        </div>

        <!-- Khung Đăng ký -->
        <div class="login-card">
            <div class="login-title">Tạo tài khoản mới</div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Ô nhập Tên -->
                <div class="form-group">
                    <label for="name">Họ và Tên</label>
                    <input id="name" class="form-control" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="VD: Nguyễn Văn A">
                    <x-input-error :messages="$errors->get('name')" class="text-red-600" />
                </div>

                <!-- Ô nhập Email -->
                <div class="form-group">
                    <label for="email">Địa chỉ Email</label>
                    <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="Nhập email của bạn">
                    <x-input-error :messages="$errors->get('email')" class="text-red-600" />
                </div>

                <!-- Ô nhập Mật khẩu -->
                <div class="form-group">
                    <label for="password">Mật khẩu</label>
                    <input id="password" class="form-control" type="password" name="password" required autocomplete="new-password" placeholder="Tạo mật khẩu (Ít nhất 8 ký tự)">
                    <x-input-error :messages="$errors->get('password')" class="text-red-600" />
                </div>

                <!-- Ô nhập Xác nhận Mật khẩu -->
                <div class="form-group">
                    <label for="password_confirmation">Xác nhận mật khẩu</label>
                    <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Nhập lại mật khẩu">
                    <x-input-error :messages="$errors->get('password_confirmation')" class="text-red-600" />
                </div>

                <!-- Nút Submit -->
                <button type="submit" class="btn-login">ĐĂNG KÝ NGAY</button>
                
                <!-- Link sang trang Đăng nhập -->
                <div style="text-align: center; margin-top: 20px; font-size: 14px; font-weight: 600; color: #57606f;">
                    Bạn đã có tài khoản? <a href="{{ route('login') }}" style="color: #ff4757; text-decoration: none;">Đăng nhập</a>
                </div>
            </form>
        </div>

        <!-- Trở về trang chủ -->
        <a href="{{ route('home') }}" class="back-home"><i class="fas fa-arrow-left"></i> Quay lại trang chủ</a>
    </div>

</body>
</html>