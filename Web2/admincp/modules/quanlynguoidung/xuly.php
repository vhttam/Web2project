<?php
include('../../config/config.php');

$tenkhachhang = $_POST['hovaten'];
$email = $_POST['email'];
$diachi = $_POST['diachi'];
$dienthoai = $_POST['dienthoai'];
$matkhau = md5($_POST['matkhau']);

// Thêm người dùng mới
if(isset($_POST['themnguoidung'])){
    $sql_them = "INSERT INTO tbl_dangky(tenkhachhang,email,diachi,dienthoai,matkhau,tinhtrang) 
                 VALUES('".$tenkhachhang."','".$email."','".$diachi."','".$dienthoai."','".$matkhau."', 1)";
    mysqli_query($mysqli, $sql_them);
    header('Location:../../index.php?action=quanlynguoidung&query=them');

// Đổi mật khẩu
} elseif(isset($_POST['doimatkhau'])) {
    $id = $_GET['iduser'];
    $sql_update = "UPDATE tbl_dangky SET matkhau='".$matkhau."' WHERE id_dangky='$id'";
    mysqli_query($mysqli, $sql_update);
    header('Location:../../index.php?action=quanlynguoidung&query=them');

// Khóa hoặc Mở khóa tài khoản
} else {
    $id = $_GET['iduser'];
    $status = $_GET['status'];
    $new_status = ($status == 1) ? 0 : 1;
    $sql_khoa = "UPDATE tbl_dangky SET tinhtrang='$new_status' WHERE id_dangky='$id'";
    mysqli_query($mysqli, $sql_khoa);
    header('Location:../../index.php?action=quanlynguoidung&query=them');
}
?>