<?php
include("../../config/config.php");

if(isset($_POST['capnhatgia'])){
    $id = $_GET['idsanpham'];
    $tyle = $_POST['tyle_loinhuan'];
    $gia_von = $_POST['gia_von'];

    // Công thức tính giá bán dựa trên tỷ lệ lợi nhuận (Làm tròn để lưu vào DB varchar)
    $gia_ban_moi = round($gia_von * (1 + ($tyle / 100)));

    // Cập nhật tỷ lệ và giá bán mới vào bảng sản phẩm
    $sql_update = "UPDATE tbl_sanpham SET 
                  tyle_loinhuan = '$tyle', 
                  giasp = '$gia_ban_moi' 
                  WHERE id_sanpham = '$id'";
    
    mysqli_query($mysqli, $sql_update);
    header("Location:../../index.php?action=quanlygiaban&query=lietke");
}
?>