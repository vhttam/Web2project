<?php
    // Lấy thông tin danh mục dựa trên ID truyền từ URL
    $sql_sua_danhmucsp = "SELECT * FROM tbl_danhmuc WHERE id_danhmuc = '".$_GET['iddanhmuc']."' LIMIT 1";
    $query_sua_danhmucsp = mysqli_query($mysqli, $sql_sua_danhmucsp);
?>

<p style="font-weight: bold; text-transform: uppercase;">Sửa danh mục sản phẩm</p>

<table border="1" width="50%" style="border-collapse: collapse;">
    <form method="POST" action="modules/quanlydanhmucsp/xuly.php?iddanhmuc=<?php echo $_GET['iddanhmuc'] ?>">
    <?php
        while($dong = mysqli_fetch_array($query_sua_danhmucsp)){
    ?>
        <tr>
            <td style="padding: 10px;">Tên danh mục sp</td>
            <td style="padding: 10px;">
                <input type="text" value="<?php echo $dong['tendanhmuc']; ?>" name="tendanhmuc" style="width: 90%;">
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center" style="padding: 15px;">
                <input type="submit" name="suadanhmuc" value="Cập nhật danh mục" style="padding: 5px 15px; cursor: pointer;">
                
                <a href="index.php?action=quanlydanhmucsanpham&query=them" 
                   style="display: inline-block; margin-left: 10px; padding: 5px 15px; background: #6c757d; color: white; text-decoration: none; border: 1px solid #333; font-size: 13px;">
                   Quay lại
                </a>
            </td>
        </tr>
    <?php
        }
    ?>
    </form>
</table>


