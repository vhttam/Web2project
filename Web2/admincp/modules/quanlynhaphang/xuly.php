<?php
include("../../config/config.php");

// 1. Khởi tạo phiếu
if(isset($_POST['taophieunhap'])){
    $ma_phieunhap = $_POST['ma_phieunhap'];
    // Dùng NOW() của MySQL để tự động lấy thời gian
    $sql_tao = "INSERT INTO tbl_phieunhap(ma_phieunhap, ngay_nhap, tinhtrang) VALUES('$ma_phieunhap', NOW(), 0)";
    mysqli_query($mysqli, $sql_tao);
    header("Location:../../index.php?action=quanlynhaphang&query=sua&idphieunhap=".mysqli_insert_id($mysqli));

// 2. Thêm từng sản phẩm vào danh sách chờ
} elseif(isset($_POST['themsanpham_vao_phieu'])){
    $id_pn = $_GET['idphieunhap'];
    $id_sp = $_POST['id_sanpham'];
    $sl = $_POST['soluong'];
    $gia = $_POST['gianhap'];

    // CHỐT CHẶN LOGIC: Giá và số lượng phải lớn hơn 0
    if($gia > 0 && $sl > 0){
        $sql_ct = "INSERT INTO tbl_chitiet_phieunhap(id_phieunhap, id_sanpham, soluong_nhap, gia_nhap) VALUES('$id_pn', '$id_sp', '$sl', '$gia')";
        mysqli_query($mysqli, $sql_ct);
        header("Location:../../index.php?action=quanlynhaphang&query=sua&idphieunhap=".$id_pn);
    } else {
        // Nếu vi phạm, hiện thông báo và quay lại trang trước
        echo '<script>alert("Lỗi: Số lượng và Giá vốn không hợp lệ"); window.history.back();</script>';
    }

// 3. Hoàn thành phiếu: Cập nhật Kho và Giá bán
} elseif(isset($_GET['hoanthanh'])){
    $id = $_GET['idphieunhap'];
    $query_ct = mysqli_query($mysqli, "SELECT * FROM tbl_chitiet_phieunhap WHERE id_phieunhap='$id'");
    
    while($row = mysqli_fetch_array($query_ct)){
        $id_sp = $row['id_sanpham'];
        $sl_nhap = $row['soluong_nhap'];
        $gia_nhap_moi = $row['gia_nhap'];

        // Lấy thông tin hiện tại của sản phẩm
        $stmt_sp = $mysqli->prepare("SELECT soluong, gianhap, tyle_loinhuan FROM tbl_sanpham WHERE id_sanpham=?");
        $stmt_sp->bind_param("i", $id_sp);
        $stmt_sp->execute();
        $sp_info = $stmt_sp->get_result()->fetch_assoc();
        
        $sl_ton = isset($sp_info['soluong']) ? $sp_info['soluong'] : 0;
        $gia_nhap_cu = isset($sp_info['gianhap']) ? $sp_info['gianhap'] : 0;
        $tyle = isset($sp_info['tyle_loinhuan']) ? $sp_info['tyle_loinhuan'] : 0;

        // TÍNH TOÁN GIÁ NHẬP BÌNH QUÂN TĨNH
        $tong_sl = $sl_ton + $sl_nhap;
        if($tong_sl > 0) {
            $gianhap_bq = (($sl_ton * $gia_nhap_cu) + ($sl_nhap * $gia_nhap_moi)) / $tong_sl;
        } else {
            $gianhap_bq = $gia_nhap_moi; // Nếu tồn kho bằng 0, lấy luôn giá mới
        }
        
        // GIÁ BÁN = Giá nhập bình quân * (1 + tỷ lệ%)
        $giasp_moi = $gianhap_bq * (1 + ($tyle / 100));

        // CẬP NHẬT KHO VÀ GIÁ
        $stmt_update = $mysqli->prepare("UPDATE tbl_sanpham SET soluong=?, gianhap=?, giasp=? WHERE id_sanpham=?");
        $stmt_update->bind_param("iddi", $tong_sl, $gianhap_bq, $giasp_moi, $id_sp);
        $stmt_update->execute();
    }
    
    
    // Đánh dấu phiếu nhập đã hoàn thành
    mysqli_query($mysqli, "UPDATE tbl_phieunhap SET tinhtrang=1 WHERE id_phieunhap='$id'");
    header("Location:../../index.php?action=quanlynhaphang&query=them");
}
// 4. Xóa sản phẩm khỏi phiếu nhập (khi chưa hoàn thành)
elseif(isset($_GET['xoasanpham'])){
    $id_chitiet = $_GET['idchitiet'];
    $id_pn = $_GET['idphieunhap'];
    
    // Kiểm tra tình trạng phiếu trước khi cho phép xóa (bảo mật thêm)
    $sql_check = "SELECT tinhtrang FROM tbl_phieunhap WHERE id_phieunhap = '$id_pn' LIMIT 1";
    $query_check = mysqli_query($mysqli, $sql_check);
    $row_check = mysqli_fetch_array($query_check);
    
    if($row_check['tinhtrang'] == 0){
        $sql_xoa = "DELETE FROM tbl_chitiet_phieunhap WHERE id_chitiet = '$id_chitiet'";
        mysqli_query($mysqli, $sql_xoa);
        header("Location:../../index.php?action=quanlynhaphang&query=sua&idphieunhap=".$id_pn);
    } else {
        echo '<script>alert("Phiếu đã hoàn thành, không thể xóa sản phẩm!"); window.history.back();</script>';
    }
}
?>