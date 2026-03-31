<?php
$code = isset($_GET['code']) ? mysqli_real_escape_string($mysqli, $_GET['code']) : '';
if($code == ''){
    echo "Không tìm thấy mã đơn hàng.";
    return;
}

// Lấy thông tin cơ bản về đơn hàng từ tbl_order
$sql_order_info = "SELECT * FROM tbl_order WHERE code_order='$code' LIMIT 1";
$query_order_info = mysqli_query($mysqli, $sql_order_info);
$row = mysqli_fetch_array($query_order_info);

// Lấy danh sách sản phẩm trong đơn từ tbl_order_details
$sql_details = "SELECT * FROM tbl_order_details, tbl_sanpham 
                WHERE tbl_order_details.id_sanpham = tbl_sanpham.id_sanpham 
                AND tbl_order_details.code_order = '$code' 
                ORDER BY tbl_order_details.id_order_details DESC";
$query_details = mysqli_query($mysqli, $sql_details);
?>

<p><a href="index.php?quanly=lichsudonhang">← Quay lại lịch sử</a></p>
<h3>Chi tiết đơn hàng #<?php echo htmlspecialchars($code) ?></h3>

<div style="background:#f9f9f9; padding:15px; border:1px solid #ddd; border-radius:10px; margin-bottom:20px;">
    <p><strong>Ngày mua:</strong> <?php echo $row['order_date'] ?></p>
    <p><strong>Người nhận (Snapshot):</strong> <?php echo htmlspecialchars($row['ten_nguoi_nhan']) ?></p>
    <p><strong>Số điện thoại:</strong> <?php echo htmlspecialchars($row['sdt_nhan']) ?></p>
    <p><strong>Địa chỉ nhận:</strong> <?php echo htmlspecialchars($row['dia_chi_nhan']) ?></p>
    <p><strong>Ghi chú đơn:</strong> <?php echo htmlspecialchars($row['ghi_chu_nhan']) ?></p>
    <p><strong>Phương thức ttoán:</strong> <?php echo ($row['order_payment']=='chuyenkhoan') ? 'Chuyển khoản' : 'Tiền mặt' ?></p>
</div>

<div class="table-responsive-wrap">
<table class="table-responsive" style="width:100%; border-collapse: collapse;" border="1" cellpadding="10">
    <thead>
        <tr style="background:#1A1A1A; color: #D4AF37;">
            <th>STT</th>
            <th>Mã SP</th>
            <th>Tên sản phẩm</th>
            <th>Hình ảnh</th>
            <th>Số lượng</th>
            <th>Đơn giá</th>
            <th>Thành tiền</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $i = 0; $total_price = 0;
    while($row_dt = mysqli_fetch_array($query_details)){
        $i++;
        $subtotal = $row_dt['giasp'] * $row_dt['soluongmua'];
        $total_price += $subtotal;
    ?>
    <tr style="text-align:center">
        <td data-label="STT"><?php echo $i ?></td>
        <td data-label="Mã SP"><?php echo $row_dt['masp'] ?></td>
        <td data-label="Tên sản phẩm"><?php echo $row_dt['tensp'] ?></td>
        <td data-label="Hình ảnh"><img src="admincp/modules/quanlysp/uploads/<?php echo $row_dt['hinhanh'] ?>" width="100px"></td>
        <td data-label="Số lượng" style="font-size:18px;"><b><?php echo $row_dt['soluongmua'] ?></b></td>
        <td data-label="Đơn giá"><?php echo number_format($row_dt['giasp'],0,',','.').'đ' ?></td>
        <td data-label="Thành tiền"><?php echo number_format($subtotal,0,',','.').'đ' ?></td>
    </tr>
    <?php } ?>
    <tr class="summary-row">
        <td colspan="7" style="text-align:right; font-weight:bold; font-size:18px; padding: 15px;">
            Tổng hóa đơn: <span style="color:red;"><?php echo number_format($total_price,0,',','.').'đ' ?></span>
        </td>
    </tr>
    </tbody>
</table>
</div>