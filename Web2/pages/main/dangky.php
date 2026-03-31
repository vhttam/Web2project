<?php
if (isset($_POST['dangky'])) {
    $tenkhachhang = $_POST['hovaten'];
    $email = $_POST['email'];
    $diachi = $_POST['diachi'];
    $dienthoai = $_POST['dienthoai'];
    $matkhau = md5($_POST['matkhau']);

    $check_name = preg_match('/^[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\s]+$/u', $tenkhachhang);
    $check_phone = preg_match('/^[0-9]{10,11}$/', $dienthoai);
    $check_address = preg_match('/^[a-zA-Z0-9ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\s,.\-\/]+$/u', $diachi);

    if (!$check_name) {
        echo '<p style="color:red">Lỗi: Họ tên không hợp lệ (không được chứa số hoặc ký tự đặc biệt).</p>';
    } elseif (!$check_phone) {
        echo '<p style="color:red">Lỗi: Số điện thoại phải từ 10-11 con số.</p>';
    } elseif (!$check_address) {
        echo '<p style="color:red">Lỗi: Địa chỉ không được chứa các ký tự đặc biệt lạ.</p>';
    } else {
        $sql_dangky = mysqli_query($mysqli, "INSERT INTO tbl_dangky(tenkhachhang,email,diachi,dienthoai,matkhau) 
        VALUES ('" . $tenkhachhang . "','" . $email . "','" . $diachi . "','" . $dienthoai . "','" . $matkhau . "')");
        
        if ($sql_dangky) {
            echo '<p style="color:green">Bạn đã đăng kí thành công</p>';
            $_SESSION['dangky'] = $email;
            $_SESSION['id_dangky'] = mysqli_insert_id($mysqli);
        }
    }
}
?>

<h3 class="luxury-font" style="text-align: center; margin-bottom: 20px; text-transform: uppercase; letter-spacing: 2px;">Đăng ký tài khoản</h3>

<div style="max-width: 500px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: var(--shadow-subtle); border: 1px solid var(--color-border);">
    <form action="" method="post" autocomplete="off">
        <div class="form-group">
            <label>Họ và tên</label>
            <input type="text" name="hovaten" id="hovaten" placeholder="Nhập họ và tên..." required>
            <small id="name-error" style="color: red; display: none; margin-top: 5px;">Họ tên không hợp lệ.</small>
        </div>
        
        <div class="form-group">
            <label>Email / Tên tài khoản</label>
            <input type="text" name="email" placeholder="Nhập email hoặc tên tài khoản..." required>
        </div>
        
        <div class="form-group">
            <label>Địa chỉ</label>
            <input type="text" name="diachi" id="diachi" placeholder="Nhập địa chỉ của bạn..." required>
            <small id="address-error" style="color: red; display: none; margin-top: 5px;">Địa chỉ không chứa ký tự đặc biệt lạ.</small>
        </div>
        
        <div class="form-group">
            <label>Số điện thoại</label>
            <input type="text" name="dienthoai" id="dienthoai" placeholder="Nhập số điện thoại..." required>
            <small id="phone-error" style="color: red; display: none; margin-top: 5px;">Số điện thoại không hợp lệ.</small>
        </div>
        
        <div class="form-group">
            <label>Mật khẩu</label>
            <input type="password" name="matkhau" placeholder="Nhập mật khẩu..." required>
        </div>
        
        <div style="margin-top: 25px;">
            <input type="submit" name="dangky" value="ĐĂNG KÝ NGAY" class="btn-custom">
        </div>
        
        <p style="text-align: center; margin-top: 20px; font-size: 14px; color: var(--color-text-muted);">
            Đã có tài khoản? <a href="index.php?quanly=dangnhap" style="color: var(--color-gold); font-weight: bold;">Đăng nhập tại đây</a>
        </p>
    </form>
</div>