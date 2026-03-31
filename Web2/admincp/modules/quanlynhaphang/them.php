<p>Lập Phiếu Nhập Hàng Mới</p>
<table border="1" width="50%" style="border-collapse: collapse;">
    <form method="POST" action="modules/quanlynhaphang/xuly.php">
        <tr>
            <td>Mã phiếu nhập</td>
            <td><input type="text" name="ma_phieunhap" value="PN<?php echo time() ?>" readonly></td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="submit" name="taophieunhap" value="Khởi tạo phiếu nhập">
                <p><small>* Ngày nhập sẽ được hệ thống ghi nhận tự động.</small></p>
            </td>
        </tr>
    </form>
</table>