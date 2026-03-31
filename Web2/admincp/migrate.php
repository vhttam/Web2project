<?php
$mysqli = new mysqli("localhost","root","123456","web_mysqli");

if ($mysqli->connect_errno) {
    echo "Kết nối MySQL lỗi: " . $mysqli->connect_error;
    exit();
}

$queries = [
    "ALTER TABLE tbl_sanpham ADD donvitinh VARCHAR(50) DEFAULT ''",
    "ALTER TABLE tbl_sanpham ADD nhacungcap VARCHAR(100) DEFAULT ''",
    "ALTER TABLE tbl_sanpham ADD gianhap FLOAT DEFAULT 0"
];

foreach ($queries as $q) {
    if ($mysqli->query($q) === TRUE) {
        echo "Thành công: " . $q . "\n";
    } else {
        echo "Lỗi: " . $mysqli->error . "\n";
    }
}
$mysqli->close();
?>
