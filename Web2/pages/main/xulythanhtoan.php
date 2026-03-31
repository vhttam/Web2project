<?php
session_start();
include("../../admincp/config/config.php");

// Kiểm tra giỏ hàng có dữ liệu không
if(isset($_SESSION['id_dangky']) && isset($_SESSION['cart']) && !empty($_SESSION['cart'])){
    $id_khachhang = (int)$_SESSION['id_dangky'];
    $code_order = rand(1000, 9999);
    $now = date('Y-m-d H:i:s');
    $order_payment = isset($_POST['payment']) ? mysqli_real_escape_string($mysqli, $_POST['payment']) : 'tienmat';

    // Lấy thông tin vận chuyển đã lưu (Snapshot)
    $sql_ship = mysqli_query($mysqli, "SELECT * FROM tbl_shipping WHERE id_dangky='$id_khachhang' LIMIT 1");
    if(mysqli_num_rows($sql_ship) > 0){
        $row_ship = mysqli_fetch_array($sql_ship);
        $ten_nhan = mysqli_real_escape_string($mysqli, $row_ship['name']);
        $sdt_nhan = mysqli_real_escape_string($mysqli, $row_ship['phone']);
        $dia_chi_nhan = mysqli_real_escape_string($mysqli, $row_ship['address']);
        $ghi_chu_nhan = mysqli_real_escape_string($mysqli, $row_ship['note']);
    } else {
        header('Location:../../index.php?quanly=vanchuyen');
        exit();
    }

    // Bước 1: Lưu đơn hàng vào tbl_order
    $sql_order = "INSERT INTO tbl_order(id_khachhang, code_order, order_status, order_date, order_payment, order_shipping, ten_nguoi_nhan, sdt_nhan, dia_chi_nhan, ghi_chu_nhan) 
                  VALUES ('$id_khachhang', '$code_order', 1, '$now', '$order_payment', 1, '$ten_nhan', '$sdt_nhan', '$dia_chi_nhan', '$ghi_chu_nhan')";
    $res_order = mysqli_query($mysqli, $sql_order);

    if($res_order){
        // Bước 2: Lưu chi tiết đơn hàng vào tbl_order_details và cập nhật kho
        foreach($_SESSION['cart'] as $item){
            $id_sp = (int)$item['id'];
            $sl_mua = (int)$item['soluong'];
            
            // Lưu chi tiết
            mysqli_query($mysqli, "INSERT INTO tbl_order_details(id_sanpham, code_order, soluongmua) VALUES ('$id_sp', '$code_order', '$sl_mua')");
            
            // Cập nhật số lượng trong bảng sản phẩm
            mysqli_query($mysqli, "UPDATE tbl_sanpham SET soluong = soluong - $sl_mua, soluongban = soluongban + $sl_mua WHERE id_sanpham = '$id_sp'");
        }
        unset($_SESSION['cart']);
        header('Location:../../index.php?quanly=camon&code_order='.$code_order);
    } else {
        die("Lỗi đặt hàng: " . mysqli_error($mysqli));
    }
} else {
    header('Location:../../index.php');
}
?>