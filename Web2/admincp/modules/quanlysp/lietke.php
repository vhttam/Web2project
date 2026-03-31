<?php
    $sql_lietke_sp="SELECT * FROM tbl_sanpham,tbl_danhmuc WHERE tbl_sanpham.id_danhmuc=tbl_danhmuc.id_danhmuc ORDER BY id_sanpham DESC";
    $rows_lietke_sp=mysqli_query($mysqli,$sql_lietke_sp);
?>
    
<p>Liệt kê sản phẩm</p>
<table style="width:100%" border="1" style="border-collapse: collapse;">
    <tr>
        
    <th>Id</th>
    <th>Mã sản phẩm</th>
    <th>Tên sản phẩm</th>
    <th>Giá bán</th>
    <th>Giá nhập</th>
    <th>Số lượng</th>
    <th>Loại</th>
    <th>Hình ảnh</th>
    <th>Nội dung</th>
    <th>Tình trạng</th>
    <th>Quản lý</th>
</tr>

<?php
    $i=0;
    while($row=mysqli_fetch_array($rows_lietke_sp)){
        $i++;
?>
<tr>
    <td><?php echo $i ?></td>
    <td><?php echo $row['masp'] ?></td>
    <td><?php echo $row['tensp'] ?></td>
    <td><?php echo number_format((float)$row['giasp'], 0, ',', '.') ?>đ</td>
    <td><?php echo number_format((float)$row['gianhap'], 0, ',', '.') ?>đ<br>(+<?php echo $row['tyle_loinhuan']; ?>%)</td>
    <td><?php echo $row['soluong'] ?> <?php echo $row['donvitinh'] ?></td>
    <td><?php echo $row['tendanhmuc'] ?></td>
    <td><img src="modules/quanlysp/uploads/<?php echo $row['hinhanh'] ?>" width="150px"></td>
    <td><?php echo $row['noidung'] ?></td>
    <td><?php if($row['tinhtrang']==0) echo "Kích hoạt"; else echo "Ẩn"; ?></td>
  <td>
    <a href="modules/quanlysp/xuly.php?idsanpham=<?php echo $row['id_sanpham'] ?>">Xoá</a> |
<a href="index.php?action=quanlysanpham&query=sua&idsanpham=<?php echo $row['id_sanpham'] ?>">Sửa</a>
    </td>
</tr>
<?php
    }
?>
</table>
        