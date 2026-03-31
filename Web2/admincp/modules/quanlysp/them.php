<p>Thêm sản phẩm mới</p>
<table border="1" width="50%" style="border-collapse: collapse;">
    <form method="POST" action="modules/quanlysp/xuly.php" enctype="multipart/form-data">
        <tr>
            <td>Mã sản phẩm</td>
            <td><input type="text" name="masp" required></td>
        </tr>
        <tr>
            <td>Tên sản phẩm</td>
            <td><input type="text" name="tensp" required></td>
        </tr>
        <tr>
            <td>Giá nhập</td>
            <td><input type="number" name="gianhap" id="nhap_gianhap" min="0" step="1000" required></td>
        </tr>
        <tr>
        <td>Tỷ lệ lợi nhuận (%)</td>
                <td>
                        <input type="number" name="tyle_loinhuan" id="nhap_tyle" 
               value="0" min="0" step="1" required>
                </td>
        </tr>
        <tr>
            <td>Đơn vị tính</td>
            <td><input type="text" name="donvitinh" placeholder="Ví dụ: Cái, Chiếc, Bộ..."></td>
        </tr>
        <tr>
            <td>Nhà cung cấp</td>
            <td><input type="text" name="nhacungcap"></td>
        </tr>
        <tr>
            <td>Số lượng</td>
            <td><input type="number" name="soluong" id="nhap_soluong" min="1" required></td>
        </tr>
       <tr>
    <td>Hình ảnh</td>
    <td>
        <input type="file" name="hinhanh" id="image">
        
        <div id="preview" style="margin-top: 10px;"></div>
    </td>
</tr>
        <tr>
            <td>Nội dung / Mô tả</td>
            <td><textarea rows="10" name="noidung" style="resize: none; width: 100%;"></textarea></td>
        </tr>
        <tr>
            <td>Loại sản phẩm</td>
            <td>
                <select name="danhmuc">
                    <?php
                    // Truy vấn lấy danh sách danh mục từ database
                    $sql_danhmuc = "SELECT * FROM tbl_danhmuc ORDER BY id_danhmuc DESC";
                    $query_danhmuc = mysqli_query($mysqli, $sql_danhmuc);
                    while($row_danhmuc = mysqli_fetch_array($query_danhmuc)){
                    ?>
                    <option value="<?php echo $row_danhmuc['id_danhmuc'] ?>"><?php echo $row_danhmuc['tendanhmuc'] ?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Tình trạng</td>
            <td>
                <select name="tinhtrang">
                    <option value="0">Kích hoạt (Hiển thị)</option>
                    <option value="1">Ẩn</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center" style="padding: 10px;">
                <input type="submit" name="themsanpham" value="Thêm sản phẩm" style="padding: 5px 20px; cursor: pointer;">
            </td>
        </tr>
    </form>
</table>