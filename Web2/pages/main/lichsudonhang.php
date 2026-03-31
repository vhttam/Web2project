<?php
if(!isset($_SESSION['id_dangky'])){
    // Hiển thị giao diện yêu cầu đăng nhập sang trọng (Black & Gold)
?>
    <div style="display: flex; justify-content: center; align-items: center; min-height: 400px; padding: 20px;">
        <div style="background-color: #FFF9E5; border: 2px solid #D4AF37; padding: 60px 40px; border-radius: 8px; text-align: center; max-width: 600px; width: 100%;">
            <h2 style="color: #000; font-family: 'Times New Roman', serif; font-size: 42px; margin-bottom: 25px; letter-spacing: 2px; text-transform: uppercase;">
                VUI LÒNG ĐĂNG NHẬP
            </h2>
            <p style="color: #666; font-size: 18px; margin-bottom: 35px;">
                Bạn cần đăng nhập để xem và quản lý lịch sử đơn hàng của mình.
            </p>
            <a onclick="openAuthModal('login')" style="cursor:pointer; display: inline-block; background-color: #1A1A1A; color: #D4AF37; text-decoration: none; padding: 18px 45px; font-weight: bold; border-radius: 4px; letter-spacing: 1px; transition: 0.3s; font-size: 16px;">
                ĐĂNG NHẬP NGAY
            </a>
        </div>
    </div>
<?php
} else {
    $id_khachhang = (int)$_SESSION['id_dangky'];
    $sql_lichsu = "SELECT * FROM tbl_order WHERE id_khachhang = '$id_khachhang' ORDER BY id_order DESC";
    $query_lichsu = mysqli_query($mysqli, $sql_lichsu);
?>

    <h3 style="margin-bottom: 20px;">Lịch sử mua hàng</h3>
    <div class="table-responsive-wrap">
        <table class="table-responsive" style="width:100%; text-align:center; border-collapse:collapse;" border="1">
            <thead>
                <tr style="background:#1A1A1A; color: #D4AF37;">
                    <th style="padding: 12px;">STT</th>
                    <th>Mã đơn hàng</th>
                    <th>Người nhận</th>
                    <th>Ngày đặt</th>
                    <th>Trạng thái</th>
                    <th>Thanh toán</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $i = 0;
            if(mysqli_num_rows($query_lichsu) > 0){
                while($row = mysqli_fetch_array($query_lichsu)){
                    $i++;
            ?>
            <tr>
                <td data-label="STT" style="padding: 10px;"><?php echo $i ?></td>
                <td data-label="Mã đơn hàng"><b><?php echo $row['code_order'] ?></b></td>
                <td data-label="Người nhận"><?php echo htmlspecialchars($row['ten_nguoi_nhan']) ?></td>
                <td data-label="Ngày đặt"><?php echo $row['order_date'] ?></td>
                <td data-label="Trạng thái">
                    <?php
                    switch((int)$row['order_status']){
                        case 1: echo '<span style="color:blue; font-weight:bold;">Chưa xử lý</span>'; break;
                        case 2: echo '<span style="color:orange; font-weight:bold;">Đã xác nhận</span>'; break;
                        case 3: echo '<span style="color:green; font-weight:bold;">Đã giao xong</span>'; break;
                        case 4: echo '<span style="color:red; font-weight:bold;">Đã hủy</span>'; break;
                    }
                    ?>
                </td>
                <td data-label="Thanh toán"><?php echo ($row['order_payment']=='chuyenkhoan') ? 'Chuyển khoản' : 'Tiền mặt' ?></td>
                <td data-label="Chi tiết"><a href="index.php?quanly=xemdonhang&code=<?php echo $row['code_order'] ?>" style="color: #666; text-decoration: underline;">Chi tiết</a></td>
            </tr>
            <?php } } else { ?>
            <tr><td colspan="7" style="padding: 20px;">Bạn chưa thực hiện đơn hàng nào.</td></tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
<?php } ?>