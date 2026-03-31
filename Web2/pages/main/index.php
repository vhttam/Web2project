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
 $sql_pro="SELECT * FROM tbl_sanpham,tbl_danhmuc WHERE tbl_sanpham.id_danhmuc=tbl_danhmuc.id_danhmuc 
 AND tbl_sanpham.tinhtrang=0 AND tbl_sanpham.soluong > 1
 ORDER BY tbl_sanpham.id_sanpham DESC LIMIT $begin,9";
    $query_pro=mysqli_query($mysqli,$sql_pro);
 ?>
 
 <h3>MỚI LÊN KỆ</h3>

<ul class="product_list">
    <?php while ($row = mysqli_fetch_array($query_pro)) { ?>
    <li>
        <a href="index.php?quanly=sanpham&id=<?php echo $row['id_sanpham'] ?>">
            <img src="admincp/modules/quanlysp/uploads/<?php echo $row['hinhanh']?>">
            
            <p class="title_product"><?php echo $row['tensp']?></p>
            <p class="price_product"><?php echo number_format($row['giasp'],0,',','.').' VNĐ'?></p>
            <p class="cate_product"><?php echo $row['tendanhmuc']?></p>
        </a>
    </li>   
    <?php } ?>   
</ul>

<div style="clear:both;"></div>

<?php
$sql_trang=mysqli_query($mysqli,"SELECT * FROM tbl_sanpham WHERE tinhtrang=0 AND soluong > 1");
$row_count=mysqli_num_rows($sql_trang);
$trang=ceil($row_count/9); 
?>
<ul class="list_trang">
    <?php for($i = 1; $i <= $trang; $i++) { ?>        
        <?php $active_class = ($i == $page || ($i == 1 && $page == '')) ? 'class="active"' : ''; ?>
        <li <?php echo $active_class; ?>>
            <a href="index.php?trang=<?php echo $i ?>"><?php echo $i ?></a>
        </li>
    <?php } ?>
</ul>
