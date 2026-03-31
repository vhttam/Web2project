<?php
    // Truy vấn danh sách phiếu nhập, sắp xếp phiếu mới nhất lên đầu
    $sql_lietke_pn = "SELECT * FROM tbl_phieunhap ORDER BY id_phieunhap DESC";
    $query_lietke_pn = mysqli_query($mysqli, $sql_lietke_pn);
?>

<p>Danh sách Phiếu Nhập Hàng</p>
<table style="width:100%" border="1" style="border-collapse: collapse;">
    <tr style="background: #f1f1f1;">
        <th>Thứ tự</th>
        <th>Mã phiếu</th>
        <th>Ngày nhập</th>
        <th>Trạng thái</th>
        <th>Quản lý</th>
    </tr>

<?php
    $i = 0;
    while($row = mysqli_fetch_array($query_lietke_pn)){
        $i++;
?>
    <tr>
        <td><?php echo $i ?></td>
        <td><?php echo $row['ma_phieunhap'] ?></td>
        <td><?php echo $row['ngay_nhap'] ?></td>
        <td>
            <?php 
                if($row['tinhtrang'] == 0){
                    echo '<span style="color:blue;">Đang soạn (Chưa nhập kho)</span>';
                } else {
                    echo '<span style="color:green;">Đã hoàn thành</span>';
                }
            ?>
        </td>
        <td>
            <?php if($row['tinhtrang'] == 0){ ?>
                <a href="index.php?action=quanlynhaphang&query=sua&idphieunhap=<?php echo $row['id_phieunhap'] ?>">Sửa/Nhập SP</a>
            <?php } else { ?>
                <a href="index.php?action=quanlynhaphang&query=sua&idphieunhap=<?php echo $row['id_phieunhap'] ?>">Xem chi tiết</a>
            <?php } ?>
        </td>
    </tr>
<?php
    }
?>
</table>