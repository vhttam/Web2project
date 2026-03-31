<h2 style="text-align:center;">Quản lý đơn hàng </h2>

<?php
    $where    = " WHERE tbl_order.id_khachhang = tbl_dangky.id_dangky ";
    $order_by = " ORDER BY tbl_order.id_order DESC ";

    // Lọc theo ngày đặt hàng
    if(isset($_GET['from_date']) && $_GET['from_date'] != '' && isset($_GET['to_date']) && $_GET['to_date'] != ''){
        $from = $_GET['from_date'];
        $to   = $_GET['to_date'];
        $where .= " AND tbl_order.order_date BETWEEN '$from 00:00:00' AND '$to 23:59:59' ";
    }

    // Lọc theo trạng thái
    if(isset($_GET['status']) && $_GET['status'] != ''){
        $status = (int)$_GET['status'];
        $where .= " AND tbl_order.order_status = '$status' ";
    }

    // Sắp xếp
    if(isset($_GET['sort_address']) && $_GET['sort_address'] != ''){
        $sort     = in_array($_GET['sort_address'], ['ASC','DESC']) ? $_GET['sort_address'] : 'ASC';
        $order_by = " ORDER BY tbl_order.dia_chi_nhan $sort ";
    }

    $sql   = "SELECT * FROM tbl_order, tbl_dangky $where $order_by";
    $query = mysqli_query($mysqli, $sql);
?>

<div style="background:#f4f4f4; padding:15px; border-radius:5px; margin-bottom:20px; border:1px solid #ddd;">
    <form method="GET" action="index.php">
        <input type="hidden" name="action" value="quanlydonhang">
        <input type="hidden" name="query" value="lietke">
        <strong>Lọc đơn:</strong> <input type="date" name="from_date"> đến <input type="date" name="to_date"> 
        | <strong>Tình trạng:</strong> 
        <select name="status">
            <option value="">-- Tất cả --</option>
            <option value="1">Chưa xử lý</option>
            <option value="2">Xác nhận</option>
            <option value="3">Giao xong</option>
            <option value="4">Hủy đơn</option>
        </select>
        <input type="submit" value="Lọc báo cáo" style="padding:5px 15px; cursor:pointer; background:#111; color:#fff; border:none;">
    </form>
</div>

<table style="width:100%; border-collapse:collapse;" border="1">
    <tr style="background:#eee;">
        <th>STT</th>
        <th>Mã đơn</th>
        <th>Người nhận </th>
        <th>Địa chỉ giao (Sắp xếp: <a href="index.php?action=quanlydonhang&query=lietke&sort_address=ASC">↑</a> <a href="index.php?action=quanlydonhang&query=lietke&sort_address=DESC">↓</a>)</th>
        <th>Điện thoại</th>
        <th>Tình trạng</th>
        <th>Thời gian</th>
        <th>Quản lý</th>
    </tr>
    <?php
    $i = 0;
    while($row = mysqli_fetch_array($query)){
        $i++;
    ?>
    <tr style="text-align:center;">
        <td><?php echo $i ?></td>
        <td><?php echo $row['code_order'] ?></td>
        <td><?php echo htmlspecialchars($row['ten_nguoi_nhan']) ?></td>
        <td><?php echo htmlspecialchars($row['dia_chi_nhan']) ?></td>
        <td><?php echo htmlspecialchars($row['sdt_nhan']) ?></td>
        <td>
            <?php
            switch((int)$row['order_status']){
                case 1: echo '<b style="color:blue">Chưa xử lý</b>'; break;
                case 2: echo '<b style="color:orange">Đã xác nhận</b>'; break;
                case 3: echo '<b style="color:green">Giao xong</b>'; break;
                case 4: echo '<b style="color:red">Đã hủy</b>'; break;
            }
            ?>
        </td>
        <td><?php echo $row['order_date'] ?></td>
        <td><a href="index.php?action=donhang&query=xemdonhang&code=<?php echo $row['code_order'] ?>">Chi tiết</a></td>
    </tr>
    <?php } ?>
</table>