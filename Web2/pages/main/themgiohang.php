<?php
session_start();
include("../../admincp/config/config.php");

// Yêu cầu đăng nhập trước khi dùng giỏ hàng
if(!isset($_SESSION['dangnhap1'])){
    echo "<script>alert('Bạn cần đăng nhập để sử dụng giỏ hàng!'); window.location.href='../../index.php';</script>";
    exit();
}

// Tăng số lượng sản phẩm
if(isset($_GET['cong'])){
    $id = (int)$_GET['cong'];
    $product = array();
    foreach($_SESSION['cart'] as $item){
        if($item['id'] != $id){
            $product[] = $item;
        } else {
            // Kiểm tra tồn kho trước khi tăng
            $row_ton = mysqli_fetch_array(mysqli_query($mysqli, "SELECT soluong FROM tbl_sanpham WHERE id_sanpham='$id' LIMIT 1"));
            $ton_kho = $row_ton ? (int)$row_ton['soluong'] : 0;
            if($item['soluong'] < $ton_kho){
                $item['soluong']++;
            }
            $product[] = $item;
        }
    }
    $_SESSION['cart'] = $product;
    header('Location:../../index.php?quanly=giohang');
    exit();
}

// Giảm số lượng sản phẩm (tối thiểu là 1)
if(isset($_GET['tru'])){
    $id = (int)$_GET['tru'];
    $product = array();
    foreach($_SESSION['cart'] as $item){
        if($item['id'] != $id){
            $product[] = $item;
        } else {
            if($item['soluong'] > 1){
                $item['soluong']--;
            }
            $product[] = $item;
        }
    }
    $_SESSION['cart'] = $product;
    header('Location:../../index.php?quanly=giohang');
    exit();
}

// Xóa 1 sản phẩm khỏi giỏ
if(isset($_GET['xoa']) && $_GET['xoa']){
    $id = (int)$_GET['xoa'];
    $product = array();
    foreach($_SESSION['cart'] as $item){
        if($item['id'] != $id){
            $product[] = $item;
        }
    }
    $_SESSION['cart'] = $product;
    header('Location:../../index.php?quanly=giohang');
    exit();
}

// Xóa toàn bộ giỏ hàng
if(isset($_GET['xoatatca']) && $_GET['xoatatca'] == 1){
    unset($_SESSION['cart']);
    header('Location:../../index.php?quanly=giohang');
    exit();
}

// Thêm sản phẩm vào giỏ hàng
if(isset($_POST['themgiohang'])){
    $id = (int)$_GET['idsanpham'];

    // Lấy thông tin sản phẩm từ DB
    $sql = "SELECT * FROM tbl_sanpham WHERE id_sanpham='$id' LIMIT 1";
    $row = mysqli_fetch_array(mysqli_query($mysqli, $sql));

    if($row){
        $ton_kho = (int)$row['soluong'];

        // Không cho thêm nếu hết hàng
        if($ton_kho <= 0){
            echo "<script>alert('Sản phẩm đã hết hàng!'); window.history.back();</script>";
            exit();
        }

        $new_item = array(
            'tensanpham' => $row['tensp'],
            'id'         => $id,
            'soluong'    => 1,
            'giasp'      => $row['giasp'],
            'hinhanh'    => $row['hinhanh'],
            'masp'       => $row['masp']
        );

        if(isset($_SESSION['cart'])){
            $found = false;
            $product = array();
            foreach($_SESSION['cart'] as $item){
                if($item['id'] == $id){
                    // Sản phẩm đã có trong giỏ, không tăng thêm
                    $found = true;
                }
                $product[] = $item;
            }
            if(!$found){
                // Thêm sản phẩm mới vào giỏ
                $product[] = $new_item;
            }
            $_SESSION['cart'] = $product;
        } else {
            $_SESSION['cart'] = array($new_item);
        }
    }
    header('Location:../../index.php?quanly=giohang');
    exit();
}
?>