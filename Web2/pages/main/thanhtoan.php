<?php
    session_start();
    include("../../admincp/config/config.php"); // Đảm bảo đường dẫn đến file kết nối DB chính xác

    // 1. Kiểm tra xem khách hàng đã đăng nhập và có giỏ hàng chưa
    if(isset($_SESSION['id_khachhang']) && isset($_SESSION['cart'])){
        $id_khachhang = $_SESSION['id_khachhang'];
        $code_order = rand(0,9999); // Tạo mã đơn hàng ngẫu nhiên
        $order_status = 1; // 1 là đơn hàng mới

        // 2. Chèn vào bảng tbl_order (Thông tin đơn hàng tổng quát)
        $insert_cart = "INSERT INTO tbl_order(id_khachhang, code_order, order_status) 
                        VALUE('".$id_khachhang."','".$code_order."','".$order_status."')";
        $order_query = mysqli_query($mysqli, $insert_cart);

        if($order_query){
            // 3. Chèn chi tiết giỏ hàng vào bảng tbl_order_details
            foreach($_SESSION['cart'] as $key => $value){
                $id_sanpham = $value['id'];
                $soluong = $value['soluong'];
                
                $insert_order_details = "INSERT INTO tbl_order_details(id_sanpham, code_order, soluongmua) 
                                         VALUE('".$id_sanpham."','".$code_order."','".$soluong."')";
                mysqli_query($mysqli, $insert_order_details);
            }
            
            // 4. Xóa giỏ hàng sau khi đã lưu vào database thành công
            unset($_SESSION['cart']);
            
            // 5. Chuyển hướng đến trang thông báo thành công
            header('Location:index.php?quanly=camon');
        }
    } else {
        // Nếu chưa đăng nhập hoặc giỏ trống, quay về giỏ hàng
        header('Location:index.php?quanly=giohang');
    }
?>