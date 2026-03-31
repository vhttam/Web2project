<?php
// Dữ liệu ban đầu
$sql_dm = "SELECT * FROM tbl_danhmuc ORDER BY id_danhmuc DESC";
$query_dm = mysqli_query($mysqli, $sql_dm);

// Các tham số lọc từ GET
$keyword = isset($_GET['tukhoa']) ? trim($_GET['tukhoa']) : '';
$id_dm = isset($_GET['danhmuc']) ? $_GET['danhmuc'] : '';
$price_from = (isset($_GET['gia_tu']) && $_GET['gia_tu'] !== '') ? (int)$_GET['gia_tu'] : '';
$price_to = (isset($_GET['gia_den']) && $_GET['gia_den'] !== '') ? (int)$_GET['gia_den'] : '';

// Phân trang
$limit = 8;
$page = isset($_GET['trang']) ? (int)$_GET['trang'] : 1;
$offset = ($page - 1) * $limit;

// Điều kiện lọc (Dùng WHERE 1=1 để nối AND cho dễ)
$where = " WHERE tbl_sanpham.tinhtrang=0 AND tbl_sanpham.soluong > 1 ";
$is_search = false;

if(isset($_GET['timkiem_nangcao']) || isset($_GET['trang'])){
    $is_search = true;
    if($keyword != '') {
        $where .= " AND tbl_sanpham.tensp LIKE '%".mysqli_real_escape_string($mysqli, $keyword)."%'";
    }
    if($id_dm != '') {
        $where .= " AND tbl_sanpham.id_danhmuc = " . (int)$id_dm;
    }
    if($price_from !== '') {
        $where .= " AND CAST(tbl_sanpham.giasp AS UNSIGNED) >= " . $price_from;
    }
    if($price_to !== '') {
        $where .= " AND CAST(tbl_sanpham.giasp AS UNSIGNED) <= " . $price_to;
    }
}

// Chỉ thực hiện truy vấn nếu người dùng đã nhấn nút lọc hoặc đang ở trang thứ n
if($is_search){
    // Đếm tổng số để tính số trang
    $sql_count = "SELECT COUNT(*) as total FROM tbl_sanpham $where";
    $query_count = mysqli_query($mysqli, $sql_count);
    $row_count = mysqli_fetch_array($query_count);
    $total_rows = $row_count['total'];
    $total_pages = ceil($total_rows / $limit);

    // Lấy dữ liệu sản phẩm
    $sql_pro = "SELECT * FROM tbl_sanpham 
                JOIN tbl_danhmuc ON tbl_sanpham.id_danhmuc = tbl_danhmuc.id_danhmuc 
                $where ORDER BY tbl_sanpham.id_sanpham DESC LIMIT $offset, $limit";
    $query_pro = mysqli_query($mysqli, $sql_pro);
}
?>

<h3>Tìm kiếm nâng cao</h3>

<div style="background:#f4f4f4; padding:20px; border-radius:8px; margin-bottom:30px; border:1px solid #ddd;">
    <form action="index.php" method="GET">
        <input type="hidden" name="quanly" value="timkiemnangcao">
        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:15px;">
            <div>
                <label>Từ khóa tên sản phẩm:</label><br>
                <input type="text" name="tukhoa" value="<?php echo htmlspecialchars($keyword) ?>" placeholder="Nhập tên đồng hồ...">
            </div>
            <div>
                <label>Danh mục sản phẩm:</label><br>
                <select name="danhmuc">
                    <option value="">-- Tất cả --</option>
                    <?php while($rd = mysqli_fetch_array($query_dm)){ ?>
                        <option value="<?php echo $rd['id_danhmuc'] ?>" <?php if($id_dm == $rd['id_danhmuc']) echo 'selected' ?>>
                            <?php echo $rd['tendanhmuc'] ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div>
                <label>Khoảng giá từ (VNĐ):</label><br>
                <input type="number" name="gia_tu" min="0" value="<?php echo $price_from ?>">
            </div>
            <div>
                <label>Khoảng giá đến (VNĐ):</label><br>
                <input type="number" name="gia_den" min="0" value="<?php echo $price_to ?>">
            </div>
        </div>
        <div style="text-align:center; margin-top:15px;">
            <input type="submit" name="timkiem_nangcao" value="Tìm kiếm sản phẩm" style="background:#111; color:#D4AF37; padding:10px 40px; border:none; cursor:pointer; font-weight:bold; letter-spacing:1px;">
        </div>
    </form>
</div>

<?php if($is_search): ?>
    <ul class="product_list">
        <?php 
        if(mysqli_num_rows($query_pro) > 0){
            while($row = mysqli_fetch_array($query_pro)){ 
        ?>
            <li>
                <a href="index.php?quanly=sanpham&id=<?php echo $row['id_sanpham'] ?>">
                    <img src="admincp/modules/quanlysp/uploads/<?php echo $row['hinhanh'] ?>">
                    <p class="title_product"><?php echo $row['tensp'] ?></p>
                    <p class="price_product"><?php echo number_format($row['giasp'],0,',','.').'đ' ?></p>
                    <p style="text-align:center; color:#888; font-size:13px;"><?php echo $row['tendanhmuc'] ?></p>
                </a>
            </li>
        <?php } } else { echo "<p>Không tìm thấy sản phẩm phù hợp.</p>"; } ?>
    </ul>

    <div style="clear:both;"></div>
    
    <!-- Hiển thị phân trang -->
    <?php if(isset($total_pages) && $total_pages >= 1): ?>
    <ul class="list_trang">
        <?php for($i=1; $i<=$total_pages; $i++){ ?>
        <li <?php if($i == $page) echo 'class="active"'; ?>>
            <?php 
            // Tạo link phân trang giữ nguyên các tham số lọc
            $link = "index.php?quanly=timkiemnangcao&tukhoa=".urlencode($keyword)."&danhmuc=".urlencode($id_dm)."&gia_tu=".urlencode($price_from)."&gia_den=".urlencode($price_to)."&timkiem_nangcao=1&trang=".$i;
            ?>
            <a href="<?php echo $link ?>"><?php echo $i ?></a>
        </li>
        <?php } ?>
    </ul>
    <?php endif; ?>
<?php endif; ?>
<script> 
    const priceInputs = [document.getElementById('gia_tu'), document.getElementById('gia_den')];

    priceInputs.forEach(input => {
    if(!input) return;

    input.addEventListener('keydown', function(e) {
        if (e.key === '-' || e.key === 'e') {
            e.preventDefault();
        }
    });

    input.addEventListener('input', function() {
        if (this.value < 0) {
            this.value = 0;
            }
        });
    });
</script>