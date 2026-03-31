 <?php
  if(isset($_GET['trang'])){
        $page=$_GET['trang'];
  }else{
        $page='';
  }
  if($page==''|| $page==1){
        $begin=0;
  }else{
        $begin=($page*9)-9;
  }
  $id_danhmuc = $_GET['id'];
  $sql_pro="SELECT * FROM tbl_sanpham WHERE id_danhmuc='$id_danhmuc' AND tinhtrang=0 AND soluong > 1 ORDER BY id_sanpham DESC LIMIT $begin,9";
  $query_pro=mysqli_query($mysqli,$sql_pro);
  $sql_cate="SELECT * FROM tbl_danhmuc WHERE id_danhmuc=".$id_danhmuc." ORDER BY id_danhmuc DESC";
  $query_cate=mysqli_query($mysqli,$sql_cate);
  $row_title=mysqli_fetch_array($query_cate);
 ?>
 <h3>Danh mục sản phẩm: <?php echo $row_title['tendanhmuc'] ?></h3>
               <ul class="product_list">
                <?php
                while($row_pro=mysqli_fetch_array($query_pro)){
                ?>
                <li>
                    <a href="index.php?quanly=sanpham&id=<?php echo $row_pro['id_sanpham'] ?>">
                    <img src ="admincp/modules/quanlysp/uploads/<?php echo $row_pro['hinhanh'] ?>" >
                    <p class="title_product"><?php echo $row_pro['tensp'] ?></p>
                    <p class="price_product"><?php echo number_format($row_pro['giasp'],0,',','.').' VNĐ' ?></p>
                    <p class="cate_product"><?php echo $row_title['tendanhmuc'] ?></p>
                    </a>
                </li>
                <?php
                }
                ?>
               </ul>
<div style="clear:both;"></div>
<?php
$sql_trang=mysqli_query($mysqli,"SELECT * FROM tbl_sanpham WHERE id_danhmuc='$id_danhmuc' AND tinhtrang=0 AND soluong > 1");
$row_count=mysqli_num_rows($sql_trang);
$trang=ceil($row_count/9); 
if($trang == 0) {
    $trang = 1;
}
?>
<ul class="list_trang">
    <?php for($i = 1; $i <= $trang; $i++) { ?>        
        <?php $active_class = ($i == $page || ($i == 1 && $page == '')) ? 'class="active"' : ''; ?>
        <li <?php echo $active_class; ?>>
            <a href="index.php?quanly=danhmucsanpham&id=<?php echo $id_danhmuc; ?>&trang=<?php echo $i ?>"><?php echo $i ?></a>
        </li>
    <?php } ?>
</ul>