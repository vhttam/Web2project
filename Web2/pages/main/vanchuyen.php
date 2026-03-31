<div class="container">
    <div class="arrow-steps clearfix" style="margin-bottom: 30px;">
        <div class="step done"> <span><a href="index.php?quanly=giohang">Giỏ hàng</a></span> </div>
        <div class="step current"> <span><a href="index.php?quanly=vanchuyen">Thông tin chuyển hàng</a></span> </div>
        <div class="step"> <span><a href="index.php?quanly=thongtinthanhtoan">Thanh toán</a></span> </div>
        <div class="step"> <span><a href="index.php?quanly=donhangdadat">Lịch sử đơn hàng</a></span> </div>
    </div>

    <h4>Thông tin vận chuyển</h4>

    <?php
    // KIỂM TRA ĐĂNG NHẬP
    if(!isset($_SESSION['id_dangky'])){
        echo '<script>alert("Vui lòng đăng nhập để tiếp tục!"); window.location.href="index.php?quanly=dangnhap";</script>';
        exit();
    }

    $id_dangky = $_SESSION['id_dangky'];

    // XỬ LÝ KHI NGƯỜI DÙNG NHẤN NÚT LƯU/CẬP NHẬT
    if(isset($_POST['themvanchuyen'])){
        $name    = mysqli_real_escape_string($mysqli, $_POST['name']);
        $phone   = mysqli_real_escape_string($mysqli, $_POST['phone']);
        $address = mysqli_real_escape_string($mysqli, $_POST['address']);
        $note    = mysqli_real_escape_string($mysqli, $_POST['note']);

        $sql_them = mysqli_query($mysqli, "INSERT INTO tbl_shipping(name, phone, address, note, id_dangky) VALUES ('$name', '$phone', '$address', '$note', '$id_dangky')");
        if($sql_them){
            echo '<script>alert("Lưu thông tin thành công!"); window.location.href="index.php?quanly=thongtinthanhtoan";</script>';
        }
    } elseif(isset($_POST['capnhatvanchuyen'])) {
        $name    = mysqli_real_escape_string($mysqli, $_POST['name']);
        $phone   = mysqli_real_escape_string($mysqli, $_POST['phone']);
        $address = mysqli_real_escape_string($mysqli, $_POST['address']);
        $note    = mysqli_real_escape_string($mysqli, $_POST['note']);

        $sql_update = mysqli_query($mysqli, "UPDATE tbl_shipping SET name='$name', phone='$phone', address='$address', note='$note' WHERE id_dangky='$id_dangky'");
        if($sql_update){
            echo '<script>alert("Cập nhật thành công!"); window.location.href="index.php?quanly=thongtinthanhtoan";</script>';   
        }
    }

    // LẤY DỮ LIỆU ĐỂ ĐỔ VÀO FORM
    // Kiểm tra xem đã có trong bảng shipping chưa
    $sql_get_vanchuyen = mysqli_query($mysqli, "SELECT * FROM tbl_shipping WHERE id_dangky='$id_dangky' LIMIT 1");
    $count = mysqli_num_rows($sql_get_vanchuyen);

    if($count > 0){
        // Nếu đã có thông tin vận chuyển
        $row_v = mysqli_fetch_array($sql_get_vanchuyen);
        $name = $row_v['name']; 
        $phone = $row_v['phone']; 
        $address = $row_v['address']; 
        $note = $row_v['note'];
    } else {
        // Nếu chưa có, lấy từ bảng đăng ký (Hãy đảm bảo tên cột tenkhachhang, dienthoai, diachi đúng với DB của bạn)
        $sql_get_dangky = mysqli_query($mysqli, "SELECT * FROM tbl_dangky WHERE id_dangky='$id_dangky' LIMIT 1");
        $row_d = mysqli_fetch_array($sql_get_dangky);
        
        $name = isset($row_d['tenkhachhang']) ? $row_d['tenkhachhang'] : ''; 
        $phone = isset($row_d['dienthoai']) ? $row_d['dienthoai'] : ''; 
        $address = isset($row_d['diachi']) ? $row_d['diachi'] : ''; 
        $note = ''; 
    }
    ?>

    <div class="row">
        <div class="col-md-12">
            <div style="max-width: 600px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: var(--shadow-subtle); border: 1px solid var(--color-border);">
                <form action="" autocomplete="off" method="POST">
                    <div class="form-group">
                        <label>Họ và tên người nhận</label>
                        <input type="text" name="name" placeholder="Nhập họ tên người nhận..." value="<?php echo $name ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Số điện thoại</label>
                        <input type="text" name="phone" placeholder="Nhập số điện thoại..." value="<?php echo $phone ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Địa chỉ nhận hàng</label>
                        <input type="text" name="address" placeholder="Nhập chi tiết địa chỉ giao hàng..." value="<?php echo $address ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Ghi chú (nếu có)</label>
                        <input type="text" name="note" placeholder="Ví dụ: Giao giờ hành chính..." value="<?php echo $note ?>">
                    </div>

                    <div style="margin-top: 30px;">
                        <?php if($count > 0){ ?>
                            <button type="submit" name="capnhatvanchuyen" class="btn-custom">CẬP NHẬT VÀ TIẾP TỤC</button>
                        <?php } else { ?>
                            <button type="submit" name="themvanchuyen" class="btn-custom">LƯU THÔNG TIN VÀ TIẾP TỤC</button>
                        <?php } ?>
                    </div>
                </form>
            </div>
        </div>

        <div style="margin-top:40px; width: 100%;">
            <h5>Kiểm tra lại giỏ hàng</h5>
            <div class="table-responsive-wrap">
            <table class="table-responsive" style="width:100%; text-align:center; border-collapse:collapse;" border="1">
                <thead>
                    <tr style="background:#111; color:#fff;">
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
                if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])){
                    $i=0; $tongtien=0;
                    foreach($_SESSION['cart'] as $item){
                        $thanhtien = $item['soluong'] * $item['giasp'];
                        $tongtien += $thanhtien;
                        $i++;
                ?>
                    <tr>
                        <td data-label="STT"><?php echo $i ?></td>
                        <td data-label="Mã sp"><?php echo $item['masp'] ?></td>
                        <td data-label="Tên SP"><?php echo $item['tensanpham'] ?></td>
                        <td data-label="Hình ảnh"><img src="admincp/modules/quanlysp/uploads/<?php echo $item['hinhanh'] ?>" width="100px"></td>
                        <td data-label="Số lượng"><?php echo $item['soluong'] ?></td>
                        <td data-label="Giá"><?php echo number_format($item['giasp'],0,',','.').'đ' ?></td>
                        <td data-label="Thành tiền"><b><?php echo number_format($thanhtien,0,',','.').'đ' ?></b></td>
                    </tr>
                <?php } ?>
                    <tr class="summary-row">
                        <td colspan="7" style="padding:15px;">
                            <h4 style="color:red; margin:0;">Tổng cộng: <?php echo number_format($tongtien,0,',','.').' VNĐ' ?></h4>
                        </td>
                    </tr>
                <?php } else { ?>
                    <tr class="empty-cart-row"><td colspan="7">Giỏ hàng trống</td></tr>
                <?php } ?>
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>