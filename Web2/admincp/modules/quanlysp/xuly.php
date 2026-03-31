<?php
include("../../config/config.php");

// 1. Lấy và làm sạch dữ liệu từ POST
$masp = isset($_POST['masp']) ? $_POST['masp'] : '';
$tensp = isset($_POST['tensp']) ? $_POST['tensp'] : '';
$gianhap = isset($_POST['gianhap']) ? (float)$_POST['gianhap'] : 0;
$tyle_loinhuan = isset($_POST['tyle_loinhuan']) ? (float)$_POST['tyle_loinhuan'] : 0;
$soluong = isset($_POST['soluong']) ? (int)$_POST['soluong'] : 0;
$noidung = isset($_POST['noidung']) ? $_POST['noidung'] : '';
$tinhtrang = isset($_POST['tinhtrang']) ? (int)$_POST['tinhtrang'] : 0;
$danhmuc = isset($_POST['danhmuc']) ? (int)$_POST['danhmuc'] : 0;
$donvitinh = isset($_POST['donvitinh']) ? $_POST['donvitinh'] : '';
$nhacungcap = isset($_POST['nhacungcap']) ? $_POST['nhacungcap'] : '';

// --- CHỐT CHẶN LOGIC: CHẶN SỐ ÂM TỪ SERVER ---
if($gianhap < 0 || $tyle_loinhuan < 0 || $soluong < 0) {
    echo '<script>alert("Lỗi: Giá nhập, Tỷ lệ và Số lượng không được là số âm!"); window.history.back();</script>';
    exit();
}

// 2. Tính giá bán dựa trên tỷ lệ lợi nhuận
$giasp = $gianhap * (1 + $tyle_loinhuan / 100);

// 3. Xử lý hình ảnh
$hinhanh = isset($_FILES['hinhanh']['name']) ? $_FILES['hinhanh']['name'] : '';
$hinhanh_tmp = isset($_FILES['hinhanh']['tmp_name']) ? $_FILES['hinhanh']['tmp_name'] : '';
$hinhanh_time = time().'_'.$hinhanh;

// --- THỰC THI CÁC HÀNH ĐỘNG ---

if(isset($_POST['themsanpham'])){
    // THÊM SẢN PHẨM
    if($hinhanh != '') {
        move_uploaded_file($hinhanh_tmp, 'uploads/'.$hinhanh_time);
    } else {
        $hinhanh_time = '';
    }
    
    $stmt = $mysqli->prepare("INSERT INTO tbl_sanpham(masp, tensp, giasp, gianhap, tyle_loinhuan, soluong, hinhanh, noidung, tinhtrang, id_danhmuc, donvitinh, nhacungcap) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssddiisssiss", $masp, $tensp, $giasp, $gianhap, $tyle_loinhuan, $soluong, $hinhanh_time, $noidung, $tinhtrang, $danhmuc, $donvitinh, $nhacungcap);
    $stmt->execute();
    
    header("Location:../../index.php?action=quanlysanpham&query=them");

} elseif(isset($_POST['suasanpham'])){
    $id = $_GET['idsanpham'];
    // SỬA SẢN PHẨM
    if(!empty($hinhanh)){
        // Cập nhật và thay ảnh mới
        move_uploaded_file($hinhanh_tmp, 'uploads/'.$hinhanh_time);
        $stmt = $mysqli->prepare("UPDATE tbl_sanpham SET masp=?, tensp=?, giasp=?, gianhap=?, tyle_loinhuan=?, soluong=?, hinhanh=?, noidung=?, tinhtrang=?, id_danhmuc=?, donvitinh=?, nhacungcap=? WHERE id_sanpham=?");
        $stmt->bind_param("ssddiisssissi", $masp, $tensp, $giasp, $gianhap, $tyle_loinhuan, $soluong, $hinhanh_time, $noidung, $tinhtrang, $danhmuc, $donvitinh, $nhacungcap, $id);
    } else {
        // Cập nhật và giữ lại ảnh cũ
        $stmt = $mysqli->prepare("UPDATE tbl_sanpham SET masp=?, tensp=?, giasp=?, gianhap=?, tyle_loinhuan=?, soluong=?, noidung=?, tinhtrang=?, id_danhmuc=?, donvitinh=?, nhacungcap=? WHERE id_sanpham=?");
        $stmt->bind_param("ssddiississi", $masp, $tensp, $giasp, $gianhap, $tyle_loinhuan, $soluong, $noidung, $tinhtrang, $danhmuc, $donvitinh, $nhacungcap, $id);
    }
    $stmt->execute();
    header("Location:../../index.php?action=quanlysanpham&query=them");

} else {
    // XÓA SẢN PHẨM
    $id = $_GET['idsanpham'];
    
    // Kiểm tra xem sản phẩm đã có trong phiếu nhập hàng chưa để tránh lỗi dữ liệu
    $stmt_check = $mysqli->prepare("SELECT id_chitiet FROM tbl_chitiet_phieunhap WHERE id_sanpham=? LIMIT 1");
    $stmt_check->bind_param("i", $id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    
    if($result_check->num_rows > 0) {
        // Nếu đã từng nhập hàng, chỉ cho phép ẨN sản phẩm để giữ lịch sử kho
        $stmt_hide = $mysqli->prepare("UPDATE tbl_sanpham SET tinhtrang=1 WHERE id_sanpham=?");
        $stmt_hide->bind_param("i", $id);
        $stmt_hide->execute();
    } else {
        // Nếu chưa từng nhập hàng, tiến hành xóa file ảnh và xóa dữ liệu
        $stmt_img = $mysqli->prepare("SELECT hinhanh FROM tbl_sanpham WHERE id_sanpham=?");
        $stmt_img->bind_param("i", $id);
        $stmt_img->execute();
        $res = $stmt_img->get_result();
        if($row = $res->fetch_assoc()) {
            if(!empty($row['hinhanh']) && file_exists('uploads/'.$row['hinhanh'])) {
                unlink('uploads/'.$row['hinhanh']);
            }
        }
        $stmt_del = $mysqli->prepare("DELETE FROM tbl_sanpham WHERE id_sanpham=?");
        $stmt_del->bind_param("i", $id);
        $stmt_del->execute();
    }
    
    header("Location:../../index.php?action=quanlysanpham&query=them");
}
?>