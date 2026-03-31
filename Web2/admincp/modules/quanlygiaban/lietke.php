<?php
    // Truy vấn lấy sản phẩm kèm giá vốn mới nhất từ chi tiết phiếu nhập
    $sql_giaban = "SELECT sp.*, dm.tendanhmuc 
                  FROM tbl_sanpham sp 
                  JOIN tbl_danhmuc dm ON sp.id_danhmuc = dm.id_danhmuc 
                  ORDER BY sp.id_sanpham DESC";
    $query_giaban = mysqli_query($mysqli, $sql_giaban);
?>

<h3>Quản lý Giá bán & Tỷ lệ Lợi nhuận</h3>
<style>
    .table-nhap-kho {
        width: 100%;
        border-collapse: collapse; /* Gộp các đường kẻ lại làm một */
        margin-top: 15px;
    }

    .table-nhap-kho th, 
    .table-nhap-kho td {
        border: 1px solid #ddd; /* Tạo đường kẻ xám nhạt */
        padding: 10px;
        text-align: center;
    }

    .table-nhap-kho thead {
        background-color: #f4f4f4; /* Màu nền cho tiêu đề bảng */
    }

    .table-nhap-kho tr:hover {
        background-color: #f9f9f9; /* Hiệu ứng đổi màu khi di chuột qua hàng */
    }

    .table-nhap-kho input[type="number"] {
        padding: 5px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
</style>
<table class="table-nhap-kho">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên sản phẩm</th>
            <th>Danh mục</th>
            <th>Giá nhập (Bình quân)</th>
            <th>Tỷ lệ lợi nhuận (%)</th>
            <th>Giá bán hiện tại (Web)</th>
            <th>Cập nhật</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = mysqli_fetch_array($query_giaban)){ 
            $gia_von = $row['gianhap'] ? $row['gianhap'] : 0;
        ?>
        <form method="POST" action="modules/quanlygiaban/xuly.php?idsanpham=<?php echo $row['id_sanpham'] ?>">
            <tr>
                <td><?php echo $row['id_sanpham'] ?></td>
                <td style="text-align:left;"><?php echo $row['tensp'] ?></td>
                <td><?php echo $row['tendanhmuc'] ?></td>
                <td><?php echo number_format($gia_von, 0, ',', '.') ?>đ</td>
                <td>
                    <input type="number" name="tyle_loinhuan" value="<?php echo $row['tyle_loinhuan'] ?>" min="0" style="width:60px; text-align:center;"> %
                </td>
                <td style="color: blue; font-weight: bold;">
                    <?php echo number_format($row['giasp'], 0, ',', '.') ?>đ
                </td>
                <td>
                    <input type="hidden" name="gia_von" value="<?php echo $gia_von ?>">
                    <input type="submit" name="capnhatgia" value="Lưu" style="background:#007bff; color:white; border:none; padding:5px 10px; cursor:pointer; border-radius:3px;">
                </td>
            </tr>
        </form>
        <?php } ?>
    </tbody>
</table>