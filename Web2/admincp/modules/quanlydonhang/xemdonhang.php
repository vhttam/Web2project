<?php
$code = isset($_GET['code']) ? mysqli_real_escape_string($mysqli, $_GET['code']) : '';

// Lấy thông tin chung của đơn hàng từ tbl_order
$sql_info = "SELECT * FROM tbl_order WHERE code_order='$code' LIMIT 1";
$query_info = mysqli_query($mysqli, $sql_info);
$row_info = mysqli_fetch_array($query_info);

// Lấy chi tiết các sản phẩm trong đơn từ tbl_order_details
$sql_details = "SELECT * FROM tbl_order_details, tbl_sanpham 
                WHERE tbl_order_details.id_sanpham = tbl_sanpham.id_sanpham 
                AND tbl_order_details.code_order = '$code' 
                ORDER BY tbl_order_details.id_order_details DESC";
$query_details = mysqli_query($mysqli, $sql_details);
?>

<h3 style="text-align:center;">Chi tiết đơn hàng #<?php echo htmlspecialchars($code) ?></h3>

<div style="background:#f9f9f9; padding:15px; border:1px solid #ddd; margin-bottom:20px; border-radius:5px;">
    <p><strong>Thời điểm đặt hàng:</strong> <?php echo $row_info['order_date'] ?></p>
    <p><strong>Tên người nhận:</strong> <?php echo htmlspecialchars($row_info['ten_nguoi_nhan']) ?></p>
    <p><strong>Số điện thoại:</strong> <?php echo htmlspecialchars($row_info['sdt_nhan']) ?></p>
    <p><strong>Địa chỉ giao:</strong> <?php echo htmlspecialchars($row_info['dia_chi_nhan']) ?></p>
    <p><strong>Ghi chú:</strong> <?php echo htmlspecialchars($row_info['ghi_chu_nhan']) ?></p>
    <hr>
    
    <!-- Cập nhật tình trạng đơn hàng tại đây -->
    <form action="modules/quanlydonhang/xuly.php" method="POST">
        <input type="hidden" name="code_order" value="<?php echo $code ?>">
        <strong>Tình trạng đơn:</strong>
        <select name="tinhtrangdonhang" style="padding:5px;">
            <option value="1" <?php if($row_info['order_status']==1) echo 'selected' ?>>Chưa xử lý (Đơn mới)</option>
            <option value="2" <?php if($row_info['order_status']==2) echo 'selected' ?>>Đã xác nhận thanh toán</option>
            <option value="3" <?php if($row_info['order_status']==3) echo 'selected' ?>>Giao hàng thành công</option>
            <option value="4" <?php if($row_info['order_status']==4) echo 'selected' ?>>Đã hủy đơn hàng</option>
        </select>
        <input type="submit" name="update_order" value="Cập nhật trạng thái" 
       style="cursor:pointer; background:#27ae60; color:white; border:none; padding:8px 20px; font-weight:bold; margin-left:10px;">

<a href="index.php?action=quanlydonhang&query=lietke" 
   style="display:inline-block; text-decoration:none; cursor:pointer; background:#7f8c8d; color:white; padding:8px 20px; font-weight:bold; margin-left:10px; font-size:13.3px;">
   Quay lại
</a>
    </form>
</div>

<table style="width:100%; border-collapse:collapse;" border="1">
    <tr style="background:#eee;">
        <th>STT</th>
        <th>Mã sản phẩm</th>
        <th>Tên sản phẩm</th>
        <th>Số lượng mua</th>
        <th>Giá tiền</th>
        <th>Thành tiền</th>
    </tr>
    <?php
    $i = 0; $total = 0;
    while($rd = mysqli_fetch_array($query_details)){
        $i++;
        $st = $rd['giasp'] * $rd['soluongmua'];
        $total += $st;
    ?>
    <tr style="text-align:center;">
        <td><?php echo $i ?></td>
        <td><?php echo $rd['masp'] ?></td>
        <td><?php echo $rd['tensp'] ?></td>
        <td style="font-size:18px;"><b><?php echo $rd['soluongmua'] ?></b></td>
        <td><?php echo number_format($rd['giasp'],0,',','.').'đ' ?></td>
        <td><b><?php echo number_format($st,0,',','.').'đ' ?></b></td>
    </tr>
    <?php } ?>
    <tr>
        <td colspan="6" style="text-align:right; padding:15px; font-size:18px;">
            <b style="color:red;">Tổng doanh thu đơn hàng: <?php echo number_format($total,0,',','.').'đ' ?></b>
        </td>
    </tr>
</table>