<?php
    // Lấy ID từ URL, nếu không có thì mặc định là 0
    $id = isset($_GET['idsanpham']) ? $_GET['idsanpham'] : 0;

    // Truy vấn dữ liệu dựa trên ID vừa lấy
    $sql_sua_sp = "SELECT * FROM tbl_sanpham WHERE id_sanpham = '$id' LIMIT 1";
    $query_sua_sp = mysqli_query($mysqli, $sql_sua_sp);
?>
<p>Sửa sản phẩm</p>
<table border="1" width="50%" style="border-collapse: collapse;">
<?php
    while($row=mysqli_fetch_array($query_sua_sp)){
?> 
    <form method="POST" action="modules/quanlysp/xuly.php?idsanpham=<?php echo $row['id_sanpham'] ?>" enctype="multipart/form-data">
        <tr>
            <td>Mã sp</td>
            <td><input type="text" value="<?php echo $row['masp'] ?>" name="masp"></td>
        </tr>
        <tr>
            <td>Tên sp</td>
            <td><input type="text" value="<?php echo $row['tensp'] ?>" name="tensp"></td>
        </tr>
        <tr>
            <td>Giá nhập</td>
            <td><input type="number" value="<?php echo $row['gianhap'] ?>" name="gianhap" id="nhap_gianhap" min="0" required></td>
        </tr>
        <tr>
            <td>Tỷ lệ LN (%)</td>
            <td><input type="number" value="<?php echo $row['tyle_loinhuan'] ?>" name="tyle_loinhuan" id="nhap_tyle" min="0" required></td>
        </tr>
        <tr>
            <td>Đơn vị tính</td>
            <td><input type="text" value="<?php echo $row['donvitinh'] ?>" name="donvitinh"></td>
        </tr>
          <tr>
        <td>Hình ảnh</td>
        <td>
            <input type="file" name="hinhanh" id="image">
            
            <div id="preview" style="margin-top: 10px;"></div>
        </td>
    </tr>
        <tr>
            <td>Số lượng</td>
            <td><input type="number" value="<?php echo $row['soluong'] ?>" name="soluong" id="nhap_soluong" min="1" required></td>
        </tr>
        <tr>
            <td>Hình ảnh</td>
            <td>
                <input type="file" name="hinhanh">
                <img src="modules/quanlysp/uploads/<?php echo $row['hinhanh'] ?>" width="150px">
            </td>
        </tr>
        <tr>
            <td>Nội dung</td>
            <td><textarea rows="10" name="noidung" style="resize: none;"><?php echo $row['noidung'] ?></textarea></td>
        </tr>
        <tr>
            <td>Loại sản phẩm</td>
            <td>
                <select name="danhmuc">
                    <?php
                    $sql_danhmuc="SELECT * FROM tbl_danhmuc ORDER BY id_danhmuc DESC";
                    $query_danhmuc=mysqli_query($mysqli,$sql_danhmuc);
                    while($row_danhmuc=mysqli_fetch_array($query_danhmuc)){
                        if($row_danhmuc['id_danhmuc']==$row['id_danhmuc']){
                            echo '<option value="'.$row_danhmuc['id_danhmuc'].'" selected>'.$row_danhmuc['tendanhmuc'].'</option>';
                        } else {
                            echo '<option value="'.$row_danhmuc['id_danhmuc'].'">'.$row_danhmuc['tendanhmuc'].'</option>';
                        }
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Tình trạng</td>
            <td>
                <select name="tinhtrang">
                    <option value="0" <?php if($row['tinhtrang']==0) echo "selected"; ?>>Kích hoạt</option>
                    <option value="1" <?php if($row['tinhtrang']==1) echo "selected"; ?>>Ẩn</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center" style="padding: 15px;">
                <input type="submit" name="suasanpham" value="Sửa sản phẩm" style="padding: 5px 15px; cursor: pointer;">
                <a href="index.php?action=quanlysanpham&query=them" 
                   style="display: inline-block; margin-left: 10px; padding: 5px 15px; background: #6c757d; color: white; text-decoration: none; border: 1px solid #333; font-size: 13px; border-radius: 2px;">
                   Quay lại
                </a>
            </td>
        </tr>
    </form>
<?php
    }
?>
</table>