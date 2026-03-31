<p>Thêm người dùng mới</p>
<table class="dangky" border="1" width="50%" style="border-collapse: collapse;">
    <form action="modules/quanlynguoidung/xuly.php" method="POST" autocomplete="off">
        <tr>
            <td>Họ và tên</td>
            <td>
                <input type="text" size="50" name="hovaten" id="hovaten" required>
                <br><small id="name-error" style="color: red; display: none;">Họ tên không được chứa số hoặc ký tự đặc biệt.</small>
            </td>
        </tr>
        <tr>
            <td>Tài khoản/Email</td>
            <td><input type="text" size="50" name="email" required></td>
        </tr>
        <tr>
            <td>Địa chỉ</td>
            <td>
                <input type="text" size="50" name="diachi" id="diachi" required>
                <br><small id="address-error" style="color: red; display: none;">Địa chỉ không hợp lệ.</small>
            </td>
        </tr>
        <tr>
            <td>Số điện thoại</td>
            <td>
                <input type="text" size="50" name="dienthoai" id="dienthoai" required>
                <br><small id="phone-error" style="color: red; display: none;">Số điện thoại phải có đúng 10 chữ số.</small>
            </td>
        </tr>
        <tr>
            <td>Mật khẩu khởi tạo</td>
            <td><input type="password" size="50" name="matkhau" required></td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <input type="submit" name="themnguoidung" value="Thêm người dùng">
            </td>
        </tr>
    </form>
</table>