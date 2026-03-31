<?php
include('../../config/config.php');

// Cập nhật tình trạng đơn đặt hàng (Luật một chiều)
if(isset($_POST['update_order'])){
    $code_order      = mysqli_real_escape_string($mysqli, $_POST['code_order']);
    $status_cap_nhat = (int)$_POST['tinhtrangdonhang'];

    // Kiểm tra tình trạng hiện thời
    $sql_check = "SELECT order_status FROM tbl_order WHERE code_order='$code_order' LIMIT 1";
    $query_check = mysqli_query($mysqli, $sql_check);
    $row_check = mysqli_fetch_array($query_check);
    $old_status = (int)$row_check['order_status'];

    // 1: Đơn mới, 2: Xác nhận, 3: Đã giao, 4: Hủy đơn
    // Quy tắc: Chỉ cho phép tiến lên hoặc hủy, không cho quay lùi trạng thái
    if($old_status < 3) {
        if($status_cap_nhat > $old_status || ($status_cap_nhat == 4)) {
            mysqli_query($mysqli, "UPDATE tbl_order SET order_status='$status_cap_nhat' WHERE code_order='$code_order'");
            header('Location:../../index.php?action=quanlydonhang&query=lietke');
        } else {
            echo "<script>alert('Lỗi: Trạng thái cập nhật phải tiến lên, không được quay lui!'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Lỗi: Đơn hàng đã hoàn tất hoặc đã hủy, không thể thay đổi thêm!'); window.history.back();</script>";
    }
}
?>