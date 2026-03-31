<div style="padding: 20px;">
    <div style="text-align: center; margin-bottom: 40px;">
        <div style="width: 80px; height: 80px; background: #27ae60; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 40px;">✓</div>
        <h2 style="color: #27ae60; font-family: 'Playfair Display', serif;">ĐẶT HÀNG THÀNH CÔNG!</h2>
        <p style="color: #666; font-size: 16px;">Cảm ơn bạn đã tin tưởng lựa chọn sản phẩm từ <b>LUXWATCH</b>.</p>
    </div>

    <?php
    if(isset($_GET['code_order'])) {
        $code = mysqli_real_escape_string($mysqli, trim($_GET['code_order']));

        // Truy vấn thông tin đơn hàng từ tbl_order
        $sql_order = "SELECT * FROM tbl_order WHERE code_order = '$code' LIMIT 1";
        $result_order = mysqli_query($mysqli, $sql_order);

        if($result_order && mysqli_num_rows($result_order) > 0) {
            $order_info = mysqli_fetch_array($result_order);

            $phuong_thuc = "";
            if($order_info['order_payment']=='tienmat')        $phuong_thuc = "Tiền mặt khi nhận hàng (COD)";
            elseif($order_info['order_payment']=='chuyenkhoan') $phuong_thuc = "Chuyển khoản ngân hàng";
            else $phuong_thuc = $order_info['order_payment'];
    ?>
            <div style="background:#fff; padding:30px; border-radius:15px; border:1px solid #D4AF37; max-width: 900px; margin: 0 auto; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
                <h3 style="border-bottom: 2px solid #D4AF37; display: inline-block; padding-bottom: 10px; margin-bottom: 25px; text-transform: uppercase; letter-spacing: 1px;">Tóm tắt đơn hàng #<?php echo $code ?></h3>
                
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px;">
                    <div style="background:#fcfcfc; padding:15px; border-radius:8px;">
                        <p style="color:#888; font-size:13px; text-transform:uppercase; margin-bottom:5px;">Thông tin người nhận</p>
                        <p><strong><?php echo htmlspecialchars($order_info['ten_nguoi_nhan']) ?></strong></p>
                        <p><?php echo htmlspecialchars($order_info['sdt_nhan']) ?></p>
                        <p><?php echo htmlspecialchars($order_info['dia_chi_nhan']) ?></p>
                    </div>
                    <div style="background:#fcfcfc; padding:15px; border-radius:8px;">
                        <p style="color:#888; font-size:13px; text-transform:uppercase; margin-bottom:5px;">Chi tiết thanh toán</p>
                        <p>Phương thức: <b><?php echo $phuong_thuc ?></b></p>
                        <p>Ngày đặt: <b><?php echo date('d/m/Y H:i', strtotime($order_info['order_date'])) ?></b></p>
                        <p>Trạng thái: <b style="color:blue;">Đang xử lý</b></p>
                    </div>
                </div>

                <h5>Sản phẩm đã đặt</h5>
                <div class="table-responsive-wrap">
                    <table class="table-responsive" style="width:100%; text-align:center; border-collapse:collapse; margin-top:15px;" border="1">
                        <thead>
                            <tr style="background:#1A1A1A; color:#D4AF37;">
                                <th>Mã sản phẩm</th>
                                <th>Tên sản phẩm</th>
                                <th>Hình ảnh</th>
                                <th>Số lượng</th>
                                <th>Đơn giá</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sql_detail = "SELECT * FROM tbl_order_details, tbl_sanpham
                                       WHERE tbl_order_details.id_sanpham = tbl_sanpham.id_sanpham
                                       AND tbl_order_details.code_order = '$code'
                                       ORDER BY tbl_order_details.id_order_details DESC";
                        $query_detail = mysqli_query($mysqli, $sql_detail);
                        $tongtien = 0;
                        while($row_d = mysqli_fetch_array($query_detail)){
                            $st = $row_d['giasp'] * $row_d['soluongmua'];
                            $tongtien += $st;
                        ?>
                            <tr>
                                <td data-label="Mã SP"><?php echo $row_d['masp'] ?></td>
                                <td data-label="Tên SP"><?php echo $row_d['tensp'] ?></td>
                                <td data-label="Hình ảnh"><img src="admincp/modules/quanlysp/uploads/<?php echo $row_d['hinhanh'] ?>" width="80px"></td>
                                <td data-label="Số lượng"><b><?php echo $row_d['soluongmua'] ?></b></td>
                                <td data-label="Đơn giá"><?php echo number_format($row_d['giasp'],0,',','.') ?>đ</td>
                                <td data-label="Thành tiền"><b><?php echo number_format($st,0,',','.') ?>đ</b></td>
                            </tr>
                        <?php } ?>
                            <tr class="summary-row">
                                <td colspan="6" style="padding:20px;">
                                    <h4 style="color:red; margin:0; text-align: right;">TỔNG CỘNG: <?php echo number_format($tongtien,0,',','.') ?> VNĐ</h4>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
    <?php
        } else {
            echo "<p style='text-align:center; color:red;'>Không tìm thấy thông tin đơn hàng này.</p>";
        }
    }
    ?>
    
    <div style="text-align:center; margin-top:50px;">
        <a href="index.php" style="background:#111; color:#D4AF37; padding:18px 50px; text-decoration:none; font-weight:700; text-transform:uppercase; border-radius:4px; letter-spacing:1px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
            ← Quay lại trang chủ
        </a>
    </div>
</div>