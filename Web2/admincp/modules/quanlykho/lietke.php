<h2 style="text-align:center;">Kho hàng & Báo cáo Tồn kho</h2>

<?php
    // Logic lấy dữ liệu từ URL
    $threshold   = isset($_GET['threshold']) ? (int)$_GET['threshold'] : 5;
    $search_name = isset($_GET['search_name']) ? mysqli_real_escape_string($mysqli, $_GET['search_name']) : '';
    
    // Mốc thời gian báo cáo
    $tu_ngay  = isset($_GET['tu_ngay']) ? $_GET['tu_ngay'] : date('Y-m-01');
    $den_ngay = isset($_GET['den_ngay']) ? $_GET['den_ngay'] : date('Y-m-d');

    // Truy vấn tính toán nhập xuất dựa trên cấu trúc tbl_order mới
    $sql_kho = "
        SELECT sp.*, dm.tendanhmuc,
        (SELECT COALESCE(SUM(soluong_nhap), 0) FROM tbl_chitiet_phieunhap ct 
            JOIN tbl_phieunhap pn ON ct.id_phieunhap = pn.id_phieunhap 
            WHERE ct.id_sanpham = sp.id_sanpham AND pn.tinhtrang = 1 AND pn.ngay_nhap BETWEEN '$tu_ngay 00:00:00' AND '$den_ngay 23:59:59'
        ) as nhap_ky,
        (SELECT COALESCE(SUM(soluongmua), 0) FROM tbl_order_details cd 
            JOIN tbl_order c ON cd.code_order = c.code_order 
            WHERE cd.id_sanpham = sp.id_sanpham AND c.order_status IN (1,2,3) AND c.order_date BETWEEN '$tu_ngay 00:00:00' AND '$den_ngay 23:59:59'
        ) as xuat_ky
        FROM tbl_sanpham sp
        JOIN tbl_danhmuc dm ON sp.id_danhmuc = dm.id_danhmuc
        WHERE 1=1
    ";
    
    if($search_name != ''){
        $sql_kho .= " AND sp.tensp LIKE '%$search_name%'";
    }
    
    $sql_kho .= " ORDER BY sp.id_sanpham DESC";
    $query_kho = mysqli_query($mysqli, $sql_kho);
?>

<div style="background:#eee; padding:15px; border-radius:5px; margin-bottom:20px;">
    <form method="GET" action="index.php">
        <input type="hidden" name="action" value="quanlykho">
        <input type="hidden" name="query" value="lietke">
        <strong>Sản phẩm:</strong> <input type="text" name="search_name" value="<?php echo htmlspecialchars($search_name); ?>" placeholder="Tên sp...">
        | <strong>Kỳ báo cáo:</strong> <input type="date" name="tu_ngay" value="<?php echo $tu_ngay; ?>"> - <input type="date" name="den_ngay" value="<?php echo $den_ngay; ?>">
        
        | <strong>Cảnh báo nếu ≤:</strong> 
        <input type="number" name="threshold" id="threshold_input" value="<?php echo $threshold; ?>" min="1" style="width: 70px;">
        
        <input type="submit" value="Lọc báo cáo" style="background:#333; color:white; border:none; padding:5px 15px; cursor:pointer;">
    </form>
</div>

<table style="width:100%; border-collapse:collapse; background:white;" border="1">
    <tr style="background:#111; color:white;">
        <th>STT</th>
        <th>Tên sản phẩm</th>
        <th>Dòng máy</th>
        <th>Nhập mới (Lưu kho)</th>
        <th>Đã xuất (Trong kỳ)</th>
        <th>Số tồn hiện tại</th>
        <th>Cảnh báo</th>
    </tr>
    <?php
    $i = 0;
    while($row_k = mysqli_fetch_array($query_kho)){
        $i++;
        $tonkho = (int)$row_k['soluong']; 
    ?>
    <tr style="text-align:center; <?php if($tonkho <= $threshold) echo 'background:#fff3cd;'; ?>">
        <td><?php echo $i ?></td>
        <td><strong><?php echo $row_k['tensp'] ?></strong></td>
        <td><?php echo $row_k['tendanhmuc'] ?></td>
        <td style="color:green;">+<?php echo $row_k['nhap_ky'] ?></td>
        <td style="color:orange;">-<?php echo $row_k['xuat_ky'] ?></td>
        <td style="font-size:18px;"><strong><?php echo $tonkho ?></strong></td>
        <td>
            <?php 
                if($tonkho == 0) echo '<b style="color:red">⚠️ Hết hàng</b>';
                elseif($tonkho <= $threshold) echo '<b style="color:orange">⚡ Sắp hết!</b>';
                else echo '<span style="color:green">Ổn định</span>';
            ?>
        </td>
    </tr>
    <?php } ?>
</table>