<?php
    $sql_lietke_user = "SELECT * FROM tbl_dangky ORDER BY id_dangky DESC";
    $query_lietke_user = mysqli_query($mysqli, $sql_lietke_user);
?>
<p>Liệt kê người dùng</p>
<table style="width:100%" border="1" style="border-collapse: collapse;">
  <tr>
    <th>Id</th>
    <th>Họ và tên</th>
    <th>Tài khoản</th>
    <th>Điện thoại</th>
    <th>Tình trạng</th>
    <th>Quản lý</th>
  </tr>
  <?php
  $i = 0;
  while($row = mysqli_fetch_array($query_lietke_user)){
    $i++;
  ?>
  <tr>
    <td><?php echo $i ?></td>
    <td><?php echo $row['tenkhachhang'] ?></td>
    <td><?php echo $row['email'] ?></td>
    <td><?php echo $row['dienthoai'] ?></td>
    <td><?php echo ($row['tinhtrang']==1) ? 'Đang hoạt động' : '<span style="color:red">Đang bị khóa</span>'; ?></td>
    <td>
        <a href="modules/quanlynguoidung/xuly.php?iduser=<?php echo $row['id_dangky'] ?>&status=<?php echo $row['tinhtrang'] ?>">
            <?php echo ($row['tinhtrang']==1) ? 'Khóa' : 'Mở khóa'; ?>
        </a> | 
        <a href="?action=quanlynguoidung&query=sua&iduser=<?php echo $row['id_dangky'] ?>">Đổi mật khẩu</a>
    </td>
  </tr>
  <?php } ?>
</table>