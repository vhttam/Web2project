<?php
if (isset($_POST['dangnhap1'])) {
    $email = $_POST['email'];
    $matkhau = md5($_POST['matkhau']);

    $stmt = $mysqli->prepare("SELECT * FROM tbl_dangky WHERE email=? AND matkhau=? LIMIT 1");
    $stmt->bind_param("ss", $email, $matkhau);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row_data = $result->fetch_assoc();

        if ($row_data['tinhtrang'] == 0) {
            echo '<p style="color:red; font-weight:bold;">Tài khoản của bạn đã bị khóa. Vui lòng liên hệ quản lý.</p>';
        }
        else {
            // Đảm bảo gán đúng biến mà Giỏ hàng đang chờ
            $_SESSION['dangnhap1'] = $row_data['email']; // Lưu email vào session
            $_SESSION['id_dangky'] = $row_data['id_dangky']; // Lưu ID khách hàng vào session

            // Lưu session trước khi chuyển trang
            session_write_close();
            header("Location:index.php"); // Chuyển về trang chủ hoặc trang trước đó thay vì fix cứng giỏ hàng
            exit();
        }
    }
    else {
        echo '<p style="color:red; font-weight:bold;">Email hoặc Mật khẩu không đúng.</p>';
    }
}
?>

<h3 class="luxury-font" style="text-align: center; margin-bottom: 20px; text-transform: uppercase; letter-spacing: 2px;">Đăng nhập khách hàng</h3>

<div style="max-width: 450px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: var(--shadow-subtle); border: 1px solid var(--color-border);">
    <form action="" method="POST" autocomplete="off">
        <div class="form-group">
            <label>Tên tài khoản / Email</label>
            <input type="text" name="email" placeholder="Nhập email hoặc tên tài khoản..." required>
        </div>
        
        <div class="form-group">
            <label>Mật khẩu</label>
            <input type="password" name="matkhau" placeholder="Nhập mật khẩu..." required>
        </div>
        
        <div style="margin-top: 25px;">
            <input type="submit" name="dangnhap1" value="ĐĂNG NHẬP" class="btn-custom">
        </div>

        <div style="text-align: center; margin-top: 20px; border-top: 1px solid var(--color-border); padding-top: 20px;">
            <p style="font-size: 14px; color: var(--color-text-muted);">
                Chưa có tài khoản? <a href="index.php?quanly=dangky" style="color: var(--color-gold); font-weight: bold;">Đăng ký ngay</a>
            </p>
        </div>
    </form>
</div>