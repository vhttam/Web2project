<div style="margin: 15px 0 20px 0; text-align: left;">
    <button type="button" onclick="window.history.back()" style="background: none; border: none; font-family: 'Lato', sans-serif; font-size: 16px; font-weight: 600; color: #D4AF37; cursor: pointer; display: flex; align-items: center; gap: 8px;">
        <i class="fa fa-arrow-left"></i> Quay lại
    </button>
</div>
<h3 style="font-weight: 300; text-transform: uppercase; letter-spacing: 2px; text-align: center; margin-bottom: 30px;">Chi tiết sản phẩm</h3>
<?php
// Lấy id sản phẩm từ URL, ép kiểu int để tránh lỗi SQL
$id_sp = (int)$_GET['id'];
$sql_chitiet = "SELECT * FROM tbl_sanpham, tbl_danhmuc
    WHERE tbl_sanpham.id_danhmuc = tbl_danhmuc.id_danhmuc
    AND tbl_sanpham.id_sanpham = '$id_sp'
    AND tbl_sanpham.tinhtrang = 0
    AND tbl_sanpham.soluong > 1
    LIMIT 1";
$query_chitiet = mysqli_query($mysqli, $sql_chitiet);
while ($row_chitiet = mysqli_fetch_array($query_chitiet)) {
?>
    <div class="wrapper_chitiet" style="padding: 20px;">
        <div class="hinhanh_sanpham">
            <img width="100%" src="admincp/modules/quanlysp/uploads/<?php echo $row_chitiet['hinhanh'] ?>">
        </div>
        <form method="POST" action="pages/main/themgiohang.php?idsanpham=<?php echo $row_chitiet['id_sanpham'] ?>">
            <div class="chitiet_sanpham">
                <h3 style="margin: 0; color: #1A1A1A;"><?php echo $row_chitiet['tensp'] ?></h3>
                <p style="color: #6C757D; font-size: 14px; text-transform: uppercase;">Mã SP: <?php echo $row_chitiet['masp'] ?></p>
                <p style="color: #C5A059; font-size: 24px; font-weight: 600; margin: 20px 0;"><?php echo number_format($row_chitiet['giasp'], 0, ',', '.') . ' VNĐ' ?></p>
                
                <div style="border-top: 1px solid #E9ECEF; border-bottom: 1px solid #E9ECEF; padding: 15px 0; margin-bottom: 25px;">
                    <p style="margin: 5px 0;"><strong>Tình trạng:</strong> <?php echo ($row_chitiet['soluong'] > 0) ? 'Còn hàng ('.$row_chitiet['soluong'].')' : 'Hết hàng'; ?></p>
                    <p style="margin: 5px 0;"><strong>Danh mục:</strong> <?php echo $row_chitiet['tendanhmuc'] ?></p>
                </div>

                <?php
                // Chỉ cho thêm vào giỏ nếu còn hàng
                if($row_chitiet['soluong'] > 0){
                ?>
                <p><input class="themgiohang" name="themgiohang" type="submit" value="Thêm vào giỏ hàng"></p>
                <?php
                }else{
                ?>
               <span style="color:red; font-weight:500;">Sản phẩm đã hết hàng</span>
                <?php
                }
                ?>
            </div>
        </form>
        <div class="clear"></div>

        <div class="tabs" style="margin-top: 40px; border-top: 1px solid #E9ECEF; padding-top: 20px;">
            <ul id="tabs-nav">
                <li class="active"><a href="#noidung">Nội dung</a></li>
                <li><a href="#hinhanh">Hình ảnh</a></li>
            </ul>
            <div id="tabs-content">
                <div id="noidung" class="tab-content" style="display: block;">
                    <p><?php echo $row_chitiet['noidung'] ?></p>
                </div>
                <div id="hinhanh" class="tab-content" style="display: none;">
                    <img width="50%" src="admincp/modules/quanlysp/uploads/<?php echo $row_chitiet['hinhanh'] ?>">
                </div>
            </div>
        </div> 
    </div>
<?php
}
?>