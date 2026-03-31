<?php
// Sử dụng mật khẩu phức tạp bạn vừa tìm thấy
$mysqli = new mysqli("localhost", "c06_nhahodau", "B3uo5dZJFiJNdlln", "c06_nhahodau");

// Kiểm tra kết nối
if ($mysqli->connect_errno) {
  echo "Kết nối MySQL thất bại: " . $mysqli->connect_error;
  exit();
}

// Auto update database structure for the current project requirements
$check_column = $mysqli->query("SHOW COLUMNS FROM tbl_sanpham LIKE 'donvitinh'");
if($check_column && $check_column->num_rows == 0) {
    $mysqli->query("ALTER TABLE tbl_sanpham ADD donvitinh VARCHAR(50) DEFAULT ''");
    $mysqli->query("ALTER TABLE tbl_sanpham ADD nhacungcap VARCHAR(100) DEFAULT ''");
    $mysqli->query("ALTER TABLE tbl_sanpham ADD gianhap FLOAT DEFAULT 0");
    $mysqli->query("UPDATE tbl_sanpham SET gianhap = giasp"); // Initialize gianhap using current giasp
}