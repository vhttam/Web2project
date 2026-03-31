<?php
    // Lấy ID người dùng từ URL
    $id = $_GET['iduser'];
    $sql_sua_user = "SELECT * FROM tbl_dangky WHERE id_dangky='$id' LIMIT 1";
    $query_sua_user = mysqli_query($mysqli, $sql_sua_user);
?>

<p>Thay đổi mật khẩu người dùng</p>
<table border="1" width="50%" style="border-collapse: collapse;">
<?php
while($row = mysqli_fetch_array($query_sua_user)){
?>
    <form action="modules/quanlynguoidung/xuly.php?iduser=<?php echo $row['id_dangky'] ?>" method="POST">
        <tr>
            <td>Họ và tên</td>
            <td><strong><?php echo $row['tenkhachhang'] ?></strong></td>
        </tr>
        <tr>
            <td>Email (Tài khoản)</td>
            <td><?php echo $row['email'] ?></td>
        </tr>
        <tr>
            <td>Mật khẩu mới</td>
            <td><input type="password" size="50" name="matkhau" placeholder="Nhập mật khẩu mới tại đây..." required></td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <input type="submit" name="doimatkhau" value="Cập nhật mật khẩu" style="padding: 5px 15px; cursor: pointer;">
                
                <a href="index.php?action=quanlynguoidung&query=them" 
                   style="display: inline-block; padding: 5px 15px; background: #6c757d; color: white; text-decoration: none; border: 1px solid #333; font-size: 13.3px; margin-left: 10px;">
                   Quay lại
                </a>
            </td>
        </tr>
    </form>
<?php 
} 
?>
</table>