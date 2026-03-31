<?php
// Nếu chưa đăng nhập: hiển thị yêu cầu đăng nhập sang trọng (Black & Gold)
if(!isset($_SESSION['dangnhap1'])){
?>
    <div style="display: flex; justify-content: center; align-items: center; min-height: 400px; padding: 20px;">
        <div style="background-color: #FFF9E5; border: 2px solid #D4AF37; padding: 60px 40px; border-radius: 8px; text-align: center; max-width: 600px; width: 100%;">
            <h2 style="color: #000; font-family: 'Times New Roman', serif; font-size: 42px; margin-bottom: 25px; letter-spacing: 2px; text-transform: uppercase;">
                VUI LÒNG ĐĂNG NHẬP
            </h2>
            <p style="color: #666; font-size: 18px; margin-bottom: 35px;">
                Bạn cần đăng nhập để xem và sử dụng giỏ hàng.
            </p>
            <a onclick="openAuthModal('login')" style="cursor:pointer; display: inline-block; background-color: #1A1A1A; color: #D4AF37; text-decoration: none; padding: 18px 45px; font-weight: bold; border-radius: 4px; letter-spacing: 1px; transition: 0.3s; font-size: 16px;">
                ĐĂNG NHẬP NGAY
            </a>
        </div>
    </div>
<?php
    return; // Dừng lại, không hiển thị giỏ hàng
}
?>

<!-- Đã đăng nhập: Hiển thị giỏ hàng bình thường -->
<?php if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])){ ?>
<div class="container">
    <div class="arrow-steps clearfix">
        <div class="step current"> <span><a href="index.php?quanly=giohang">Giỏ hàng</a></span> </div>
        <div class="step"> <span><a href="index.php?quanly=vanchuyen">Thông tin chuyển hàng</a></span> </div>
        <div class="step"> <span><a href="index.php?quanly=thongtinthanhtoan">Thanh toán</a></span> </div>
        <div class="step"> <span><a href="index.php?quanly=lichsudonhang">Lịch sử đơn hàng</a></span> </div>
    </div>
</div>
<?php } ?>

<div class="table-responsive-wrap">
<table class="table-responsive" style="width:100%; text-align:center; border-collapse:collapse; margin-top:20px;" border="1">
    <thead>
        <tr style="background:#1A1A1A; color: #D4AF37;">
            <th style="padding: 12px;">STT</th>
            <th>Mã sản phẩm</th>
            <th>Tên sản phẩm</th>
            <th>Hình ảnh</th>
            <th>Số lượng</th>
            <th>Giá sản phẩm</th>
            <th>Thành tiền</th>
            <th>Quản lý</th>
        </tr>
    </thead>
    <tbody>
    <?php
    if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])){
        $i = 0; $tongtien = 0;
        foreach($_SESSION['cart'] as $cart_item){
            $thanhtien = $cart_item['soluong'] * $cart_item['giasp'];
            $tongtien += $thanhtien;
            $i++;
    ?>
        <tr>
            <td data-label="STT" style="padding: 10px;"><?php echo $i ?></td>
            <td data-label="Mã sản phẩm"><?php echo $cart_item['masp'] ?></td>
            <td data-label="Tên sản phẩm"><?php echo $cart_item['tensanpham'] ?></td>
            <td data-label="Hình ảnh"><img src="admincp/modules/quanlysp/uploads/<?php echo $cart_item['hinhanh'] ?>" width="120px"></td>
            <td data-label="Số lượng" style="font-size: 16px;">
                <a href="pages/main/themgiohang.php?tru=<?php echo $cart_item['id'] ?>" ><b>-</b></a>
                <?php echo $cart_item['soluong'] ?>
                <a href="pages/main/themgiohang.php?cong=<?php echo $cart_item['id'] ?>" ><b>+</b></a>
            </td>
            <td data-label="Giá"><?php echo number_format($cart_item['giasp'],0,',','.').'đ' ?></td>
            <td data-label="Thành tiền"><b><?php echo number_format($thanhtien,0,',','.').'đ' ?></b></td>
            <td data-label="Quản lý"><a href="pages/main/themgiohang.php?xoa=<?php echo $cart_item['id'] ?>" style="color:red; text-decoration:none;">Xóa</a></td>
        </tr>
    <?php } ?>
        <tr class="summary-row">
            <td colspan="8" style="padding: 20px;">
                <div class="cart-summary-inner">
                    <p style="float:left; font-size: 20px;"><b>Tổng cộng: </b><span style="color:red;"><?php echo number_format($tongtien,0,',','.').'vnđ' ?></span></p>
                    <p style="float:right;"><a href="pages/main/themgiohang.php?xoatatca=1" style="color:#666; font-size: 13px;">Xoá tất cả giỏ hàng</a></p>
                    <div style="clear:both;"></div>
                    <div style="margin-top:20px;">
                        <a href="index.php?quanly=vanchuyen" class="btn-custom" style="background:#D4AF37; display:inline-block; padding: 15px 40px; font-weight:bold; letter-spacing:1px; width: auto !important;">
                            TIẾP TỤC ĐẶT HÀNG
                        </a>
                    </div>
                </div>
            </td>
        </tr>
    <?php } else { ?>
        <tr class="empty-cart-row">
            <td colspan="8" style="padding: 50px;">
                <p style="font-size: 18px; color: #888;">Giỏ hàng của bạn đang trống.</p>
                <p><a href="index.php" style="color: #D4AF37;">← Quay lại mua sắm</a></p>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
</div>
