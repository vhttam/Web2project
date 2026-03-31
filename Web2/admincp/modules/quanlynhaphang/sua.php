<?php
    $id_pn = $_GET['idphieunhap'];
    $sql_pn = "SELECT * FROM tbl_phieunhap WHERE id_phieunhap='$id_pn' LIMIT 1";
    $query_pn = mysqli_query($mysqli, $sql_pn);
    $row_pn = mysqli_fetch_array($query_pn);
?>

<h3>Phiếu: <?php echo $row_pn['ma_phieunhap'] ?> (Ngày: <?php echo $row_pn['ngay_nhap'] ?>)</h3>

<?php if($row_pn['tinhtrang'] == 0){ ?>
<fieldset>
    <legend>Thêm sản phẩm vào phiếu</legend>
    <form method="POST" action="modules/quanlynhaphang/xuly.php?idphieunhap=<?php echo $id_pn ?>">
        Chọn SP: 
        <select name="id_sanpham">
            <?php 
            $sql_sp = "SELECT * FROM tbl_sanpham ORDER BY id_sanpham DESC";
            $query_sp = mysqli_query($mysqli, $sql_sp);
            while($row_sp = mysqli_fetch_array($query_sp)){
                echo '<option value="'.$row_sp['id_sanpham'].'">'.$row_sp['tensp'].'</option>';
            }
            ?>
        </select>
        
        SL: <input type="number" name="soluong" id="nhap_soluong" value="1" min="1" style="width:60px">
        
        Giá vốn: <input type="text" name="gianhap" id="nhap_gianhap" placeholder="VNĐ" min="1000">
        
        <input type="submit" name="themsanpham_vao_phieu" value="Thêm">
    </form>
</fieldset>
<?php } ?>

<table border="1" width="100%" style="margin-top:20px; border-collapse: collapse;">
    <tr style="background: #eee;">
        <th>Sản phẩm</th>
        <th>Số lượng</th>
        <th>Giá vốn</th>
        <th>Thành tiền</th>
        <?php if($row_pn['tinhtrang'] == 0){ ?>
            <th>Quản lý</th>
        <?php } ?>
    </tr>
    <?php
    $sql_list = "SELECT * FROM tbl_chitiet_phieunhap, tbl_sanpham 
                 WHERE tbl_chitiet_phieunhap.id_sanpham = tbl_sanpham.id_sanpham 
                 AND id_phieunhap='$id_pn'";
    $query_list = mysqli_query($mysqli, $sql_list);
    $tongtien = 0;
    while($row = mysqli_fetch_array($query_list)){
        $thanhtien = $row['soluong_nhap'] * $row['gia_nhap'];
        $tongtien += $thanhtien;
    ?>
    <tr>
        <td><?php echo $row['tensp'] ?></td>
        <td><?php echo $row['soluong_nhap'] ?></td>
        <td><?php echo number_format($row['gia_nhap'],0,',','.') ?>đ</td>
        <td><?php echo number_format($thanhtien,0,',','.') ?>đ</td>
        <?php if($row_pn['tinhtrang'] == 0){ ?>
            <td align="center">
                <a href="modules/quanlynhaphang/xuly.php?xoasanpham=1&idchitiet=<?php echo $row['id_chitiet'] ?>&idphieunhap=<?php echo $id_pn ?>" 
                   onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này khỏi phiếu?')">
                   Xóa
                </a>
            </td>
        <?php } ?>
    </tr>
    <?php } ?>
    <tr>
        <td colspan="3" align="right"><b>Tổng cộng:</b></td>
        <td colspan="<?php echo ($row_pn['tinhtrang'] == 0) ? '2' : '1'; ?>">
            <b><?php echo number_format($tongtien,0,',','.') ?>đ</b>
        </td>
    </tr>
</table>
    <tr>
        <td colspan="3" align="right"><b>Tổng cộng:</b></td>
        <td><b><?php echo number_format($tongtien,0,',','.') ?>đ</b></td>
    </tr>
</table>

<div style="margin-top: 20px; display: flex; gap: 10px;">
    <a href="index.php?action=quanlynhaphang&query=them" 
       style="background: #6c757d; color: white; padding: 8px 15px; text-decoration: none; border-radius: 4px;">
       Quay lại
    </a>

    <?php if($row_pn['tinhtrang'] == 0){ ?>
        <a href="modules/quanlynhaphang/xuly.php?hoanthanh=1&idphieunhap=<?php echo $id_pn ?>" 
           style="background: green; color: white; padding: 8px 15px; text-decoration: none; border-radius: 4px;"
           onclick="return confirm('Chốt phiếu sẽ tự động cộng kho và tính giá bán. Tiếp tục?')">
           HOÀN THÀNH & NHẬP KHO
        </a>
    <?php } ?>
</div>

<?php if($row_pn['tinhtrang'] != 0){ 
    echo "<p style='color:red; margin-top:15px;'><b>Trạng thái: Đã nhập kho - Không thể sửa.</b></p>"; 
} ?>