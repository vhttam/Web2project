  <?php
  // Đổi sang GET để hỗ trợ phân trang dễ dàng
  $tukhoa = isset($_GET['tukhoa']) ? trim($_GET['tukhoa']) : (isset($_POST['tukhoa']) ? trim($_POST['tukhoa']) : '');

  // Phân trang
  $limit = 8;
  if(isset($_GET['trang'])){
      $page = $_GET['trang'];
  } else {
      $page = 1;
  }
  $if_page = ($page - 1) * $limit;

  // Lấy dữ liệu với LIMIT
  $sql_pro="SELECT * FROM tbl_sanpham JOIN tbl_danhmuc ON tbl_sanpham.id_danhmuc=tbl_danhmuc.id_danhmuc 
            WHERE tbl_sanpham.tensp LIKE '%".$tukhoa."%' AND tbl_sanpham.tinhtrang=0 AND tbl_sanpham.soluong > 1 
            LIMIT $if_page, $limit";
  $query_pro=mysqli_query($mysqli,$sql_pro);

  // Lấy tổng số dòng để tính số trang
  $sql_count="SELECT id_sanpham FROM tbl_sanpham WHERE tensp LIKE '%".$tukhoa."%' AND tinhtrang=0 AND soluong > 1";
  $query_count=mysqli_query($mysqli,$sql_count);
  $total_rows = mysqli_num_rows($query_count);
  $total_pages = ceil($total_rows / $limit);
 ?>
 <h3>Tìm kiếm từ khoá: <?php echo htmlspecialchars($tukhoa); ?></h3>

               <ul class="product_list">
                <?php
                if($total_rows > 0) {
                    while ($row=mysqli_fetch_array($query_pro)){
                        ?>
                <li>
                <a href="index.php?quanly=sanpham&id=<?php echo $row['id_sanpham'] ?>">
                <img src="admincp/modules/quanlysp/uploads/<?php echo $row['hinhanh']?>" >

                    <p class="title_product">Tên sản phẩm: <?php echo $row['tensp']?></p>
                    <p class="price_product">Giá: <?php echo number_format($row['giasp'],0,',','.').'đ'?></p>
                   <p  style="text-align: center; color: #000;"><?php echo $row['tendanhmuc']?></p>
</a>
                </li>   
        <?php
                    }
                } else {
                    echo "<p>Không tìm thấy sản phẩm nào.</p>";
                }
                ?>   
               </ul>
               
<div style="clear:both;"></div>
<?php 
if($total_pages == 0) {
    $total_pages = 1;
}
?>
<ul class="list_trang">
    <?php for($i=1; $i<=$total_pages; $i++){ ?>
        <?php $active_class = ($i == $page) ? 'class="active"' : ''; ?>
        <li <?php echo $active_class; ?>>
            <a href="index.php?quanly=timkiem&tukhoa=<?php echo urlencode($tukhoa) ?>&trang=<?php echo $i ?>"><?php echo $i ?></a>
        </li>
    <?php } ?>
</ul>