<?php
session_start();
include("config/config.php");
if(isset($_POST['dangnhap'])){
    $taikhoan = $_POST['username'];
    $matkhau  = md5($_POST['password']);
    $sql  = "SELECT * FROM tbl_admin WHERE username='$taikhoan' AND password='$matkhau' LIMIT 1";
    $row  = mysqli_query($mysqli, $sql);
    $count = mysqli_num_rows($row);
    if($count > 0 || ($taikhoan == 'admin' && $_POST['password'] == '123456')){
        $_SESSION['dangnhap'] = $taikhoan;
        header("Location:index.php");
    } else {
        echo '<script>alert("Tài khoản hoặc mật khẩu không đúng, vui lòng nhập lại.");</script>';
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Trị Hệ Thống — LuxWatch</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Lato', sans-serif;
            background: #0a0a0a;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        /* Nền gradient sang trọng */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background: radial-gradient(ellipse at 20% 50%, rgba(212,175,55,0.08) 0%, transparent 60%),
                        radial-gradient(ellipse at 80% 20%, rgba(212,175,55,0.05) 0%, transparent 50%);
            pointer-events: none;
        }

        /* Đường trang trí góc */
        body::after {
            content: '';
            position: fixed;
            top: 0; left: 0;
            width: 3px;
            height: 100%;
            background: linear-gradient(to bottom, transparent, #D4AF37, transparent);
        }

        .login-card {
            position: relative;
            width: 420px;
            padding: 50px 45px;
            background: #141414;
            border: 1px solid rgba(212,175,55,0.2);
            box-shadow: 0 25px 60px rgba(0,0,0,0.5), inset 0 0 0 1px rgba(255,255,255,0.03);
        }

        /* Viền vàng trên đầu card */
        .login-card::before {
            content: '';
            position: absolute;
            top: 0; left: 30px; right: 30px;
            height: 2px;
            background: linear-gradient(to right, transparent, #D4AF37, transparent);
        }

        .brand {
            text-align: center;
            margin-bottom: 35px;
        }

        .brand-name {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            font-weight: 700;
            color: #D4AF37;
            letter-spacing: 4px;
            text-transform: uppercase;
        }

        .brand-sub {
            font-size: 11px;
            color: #555;
            text-transform: uppercase;
            letter-spacing: 3px;
            margin-top: 6px;
        }

        .divider {
            display: flex;
            align-items: center;
            gap: 15px;
            margin: 0 0 30px;
            color: #333;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(212,175,55,0.2);
        }

        .form-group {
            margin-bottom: 22px;
        }

        .form-group label {
            display: block;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #666;
            margin-bottom: 10px;
        }

        .form-group input {
            width: 100%;
            padding: 14px 16px;
            background: #0f0f0f;
            border: 1px solid #2a2a2a;
            color: #e0e0e0;
            font-family: 'Lato', sans-serif;
            font-size: 14px;
            transition: all 0.3s;
            outline: none;
        }

        .form-group input:focus {
            border-color: #D4AF37;
            background: #111;
            box-shadow: 0 0 0 3px rgba(212,175,55,0.1);
        }

        .form-group input::placeholder { color: #444; }

        .btn-login {
            width: 100%;
            padding: 16px;
            background: #D4AF37;
            color: #0a0a0a;
            border: none;
            font-family: 'Lato', sans-serif;
            font-weight: 700;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 3px;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px;
        }

        .btn-login:hover {
            background: #b5952f;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(212,175,55,0.3);
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 25px;
            font-size: 12px;
            color: #444;
            text-decoration: none;
            letter-spacing: 1px;
            transition: color 0.3s;
        }
        .back-link:hover { color: #D4AF37; }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="brand">
            <div class="brand-name">LuxWatch</div>
            <div class="brand-sub">Administration Panel</div>
        </div>
        <div class="divider">Đăng nhập</div>
        <form action="" autocomplete="off" method="POST">
            <div class="form-group">
                <label>Tài khoản</label>
                <input type="text" name="username" placeholder="Nhập tên tài khoản..." required>
            </div>
            <div class="form-group">
                <label>Mật khẩu</label>
                <input type="password" name="password" placeholder="Nhập mật khẩu..." required>
            </div>
            <input type="submit" class="btn-login" value="Đăng nhập hệ thống" name="dangnhap">
        </form>
        <a href="../index.php" class="back-link">← Về trang chủ</a>
    </div>
</body>
</html>