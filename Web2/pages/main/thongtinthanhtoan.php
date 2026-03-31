<div class="container">
    <div class="arrow-steps clearfix" style="margin-bottom: 30px;">
        <div class="step done"> <span><a href="index.php?quanly=giohang">Giỏ hàng</a></span> </div>
        <div class="step done"> <span><a href="index.php?quanly=vanchuyen">Thông tin chuyển hàng</a></span> </div>
        <div class="step current"> <span><a href="index.php?quanly=thongtinthanhtoan">Thanh toán</a></span> </div>
        <div class="step"> <span><a href="index.php?quanly=donhangdadat">Lịch sử đơn hàng</a></span> </div>
    </div>

    <?php
    if(isset($_SESSION['id_dangky'])){
        $id_dangky = $_SESSION['id_dangky'];
        $sql_ship = mysqli_query($mysqli, "SELECT * FROM tbl_shipping WHERE id_dangky='$id_dangky' LIMIT 1");
        $count = mysqli_num_rows($sql_ship);
        if($count > 0){
            $row_v = mysqli_fetch_array($sql_ship);
            $name = $row_v['name']; $phone = $row_v['phone']; $address = $row_v['address']; $note = $row_v['note'];
        } else {
            $name = ''; $phone = ''; $address = ''; $note = '';
        }
    } else {
        header('Location:index.php?quanly=giohang');
        exit();
    }
    ?>

    <form action="pages/main/xulythanhtoan.php" method="POST">
        <div class="row">
            <div class="col-md-12">
                <h4>Xác nhận thông tin giao hàng</h4>
                <div style="background:#f4f4f4; padding:20px; border-radius:8px; border-left:4px solid #D4AF37; margin-bottom:30px;">
                    <p>Họ tên nhận hàng: <b><?php echo htmlspecialchars($name) ?></b></p>
                    <p>Số điện thoại: <b><?php echo htmlspecialchars($phone) ?></b></p>
                    <p>Địa chỉ giao: <b><?php echo htmlspecialchars($address) ?></b></p>
                    <p>Ghi chú: <b><?php echo htmlspecialchars($note) ?></b></p>
                    <p style="margin-top:10px;"><a href="index.php?quanly=vanchuyen" style="color:#D4AF37; text-decoration:underline;">Thay đổi địa chỉ</a></p>
                </div>

                <h5>Xác nhận giỏ hàng</h5>
                <div class="table-responsive-wrap">
                <table class="table-responsive" style="width:100%; text-align:center; border-collapse:collapse;" border="1">
                    <thead>
                        <tr style="background:#1A1A1A; color:#D4AF37;">
                            <th>STT</th>
                            <th>Mã sp</th>
                            <th>Tên sản phẩm</th>
                            <th>Hình ảnh</th>
                            <th>Số lượng</th>
                            <th>Giá</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    if(isset($_SESSION['cart'])){
                        $i=0; $tongtien=0;
                        foreach($_SESSION['cart'] as $item){
                            $st = $item['soluong'] * $item['giasp'];
                            $tongtien += $st;
                            $i++;
                    ?>
                        <tr>
                            <td data-label="STT"><?php echo $i ?></td>
                            <td data-label="Mã sp"><?php echo $item['masp'] ?></td>
                            <td data-label="Tên SP"><?php echo $item['tensanpham'] ?></td>
                            <td data-label="Hình ảnh"><img src="admincp/modules/quanlysp/uploads/<?php echo $item['hinhanh'] ?>" width="80px"></td>
                            <td data-label="Số lượng"><?php echo $item['soluong'] ?></td>
                            <td data-label="Giá"><?php echo number_format($item['giasp'],0,',','.').'đ' ?></td>
                            <td data-label="Thành tiền"><b><?php echo number_format($st,0,',','.').'đ' ?></b></td>
                        </tr>
                    <?php } ?>
                        <tr class="summary-row">
                            <td colspan="7" style="padding:15px; text-align:right;">
                                <h4 style="color:red; margin:0;">TỔNG CỘNG: <?php echo number_format($tongtien,0,',','.').' VNĐ' ?></h4>
                            </td>
                        </tr>
                    <?php } else { ?>
                        <tr class="empty-cart-row"><td colspan="7">Giỏ hàng trống</td></tr>
                    <?php } ?>
                    </tbody>
                </table>
                </div>

                <div style="margin-top:40px; border:1px solid #ddd; border-radius:10px; padding:20px; background:#fff;">
                    <h4 style="border-bottom:1px solid #eee; padding-bottom:10px; color:#111;">Cổng thanh toán</h4>
                    
                    <div style="margin:20px 0;">
                        <input type="radio" name="payment" value="tienmat" id="pay_cash" checked onclick="toggleBank(false)">
                        <label for="pay_cash" style="font-size:16px; font-weight:bold; cursor:pointer;"> Thanh toán tiền mặt (COD)</label>
                    </div>

                    <div style="margin:20px 0;">
                        <input type="radio" name="payment" value="vnpay" id="pay_online" onclick="toggleBank(false)">
                        <label for="pay_online" style="font-size:16px; font-weight:bold; cursor:pointer;"> Thanh toán trực tuyến (VNPAY / Ví điện tử)</label>
                        <p style="font-size:13px; color:#666; margin-left:25px;">Hệ thống sẽ chuyển hướng bạn đến cổng thanh toán an toàn.</p>
                    </div>

                    <div style="margin:20px 0;">
                        <input type="radio" name="payment" value="chuyenkhoan" id="pay_bank" onclick="toggleBank(true)">
                        <label for="pay_bank" style="font-size:16px; font-weight:bold; cursor:pointer;"> Chuyển khoản ngân hàng / Quét QR</label>
                        
                        <div id="bank_details" style="display:none; margin-top:20px; padding:20px; background:#f9f9f9; border:1px solid #ddd; border-radius:8px;">
                            <div style="display:flex; flex-wrap:wrap; gap:20px; align-items:center;">
                                <div style="flex:1; min-width:250px;">
                                    <p>Ngân hàng: <b>ACB (Ngân hàng Á Châu)</b></p>
                                    <p>Chủ TK: <b>NGUYEN TRI CUONG</b></p>
                                    <p>Số tài khoản: <b style="font-size:18px;">38201717</b></p>
                                    <p>Nội dung: <b>DH #<?php echo rand(1000, 9999); ?> - SĐT: <?php echo $phone; ?></b></p>
                                </div>
                                <div style="width:200px; text-align:center;">
                                    <img src="https://img.vietqr.io/image/ACB-38201717-compact2.jpg?accountName=NGUYEN%20TRI%20CUONG" alt="VietQR" style="width:100%; border:1px solid #D4AF37; padding:5px; border-radius:8px;">
                                    <p style="font-weight:bold; font-size:12px; margin-top:5px;">VietQR chính chủ</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div style="margin-top:30px;">
                        <button type="submit" name="thanhtoanngay" class="btn-custom" style="background:#111; color:#D4AF37; width:100%; padding:15px; font-size:18px;">XÁC NHẬN ĐẶT HÀNG</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
function toggleBank(show){
    document.getElementById('bank_details').style.display = show ? 'block' : 'none';
}
</script>