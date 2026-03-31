<?php
include("../../config/config.php");
$tenloaisp=$_POST['tendanhmuc'];
$thutu=$_POST['thutu'];
if(isset($_POST['themdanhmuc'])){
    $sql_them="INSERT INTO tbl_danhmuc(tendanhmuc,thutu) VALUE('".$tenloaisp."','".$thutu."')";
    mysqli_query($mysqli,$sql_them);
    header("Location:../../index.php?action=quanlydanhmucsanpham&query=them");
}
elseif(isset($_POST['suadanhmuc'])){
$sql_update="UPDATE tbl_danhmuc SET tendanhmuc='".$tenloaisp."',thutu='".$thutu."' WHERE id_danhmuc='".$_GET['iddanhmuc']."'";
mysqli_query($mysqli,$sql_update);
header("Location:../../index.php?action=quanlydanhmucsanpham&query=them");

}else{
    $id = isset($_GET['iddanhmuc']) ? (int)$_GET['iddanhmuc'] : 0;
    
    // Kiểm tra khóa ngoại (có sản phẩm nào thuộc danh mục này không)
    $stmt_check = $mysqli->prepare("SELECT id_sanpham FROM tbl_sanpham WHERE id_danhmuc = ? LIMIT 1");
    $stmt_check->bind_param("i", $id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    
    if($result_check->num_rows > 0) {
        // Có sản phẩm -> Chặn xóa
        echo "<script>alert('Không thể xóa danh mục này vì đang chứa sản phẩm!'); window.location.href='../../index.php?action=quanlydanhmucsanpham&query=them';</script>";
        exit();
    } else {
        // Chưa có sản phẩm -> Tiến hành xóa
        $stmt_xoa = $mysqli->prepare("DELETE FROM tbl_danhmuc WHERE id_danhmuc = ?");
        $stmt_xoa->bind_param("i", $id);
        $stmt_xoa->execute();
        header("Location:../../index.php?action=quanlydanhmucsanpham&query=them");
    }
}
?> 