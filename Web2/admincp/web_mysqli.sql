-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost
-- Thời gian đã tạo: Th3 31, 2026 lúc 05:31 PM
-- Phiên bản máy phục vụ: 8.0.45-0ubuntu0.22.04.1
-- Phiên bản PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `c06_nhahodau`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id_admin` int NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `admin_status` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_admin`
--

INSERT INTO `tbl_admin` (`id_admin`, `username`, `password`, `admin_status`) VALUES
(1, 'quanly1', 'e19d5cd5af0378da05f63f891c7467af', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_chitiet_phieunhap`
--

CREATE TABLE `tbl_chitiet_phieunhap` (
  `id_chitiet` int NOT NULL,
  `id_phieunhap` int DEFAULT NULL,
  `id_sanpham` int DEFAULT NULL,
  `soluong_nhap` int NOT NULL,
  `gia_nhap` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_chitiet_phieunhap`
--

INSERT INTO `tbl_chitiet_phieunhap` (`id_chitiet`, `id_phieunhap`, `id_sanpham`, `soluong_nhap`, `gia_nhap`) VALUES
(1, 1, 15, 1, 10000),
(2, 2, 15, 1, 5000),
(3, 2, 14, 10, 10000),
(6, 7, 34, 8, 100000000),
(7, 8, 33, 4, 2000000000),
(8, 9, 33, 4, 200000000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_dangky`
--

CREATE TABLE `tbl_dangky` (
  `id_dangky` int NOT NULL,
  `tenkhachhang` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `diachi` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `matkhau` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `dienthoai` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `tinhtrang` int DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_dangky`
--

INSERT INTO `tbl_dangky` (`id_dangky`, `tenkhachhang`, `email`, `diachi`, `matkhau`, `dienthoai`, `tinhtrang`) VALUES
(7, 'thanh dang', 'dangphuthanh217', 'tphcm', 'e10adc3949ba59abbe56e057f20f883e', '1234560', 1),
(8, 'dang', 'thanh25', 'hanoi', 'e35cf7b66449df565f93c607d5a81d09', '0123456789', 1),
(9, 'thanh dang', 'thanhf', 'an', '4100c4d44da9177247e44a5fc1546778', '1234560', 1),
(10, 'Nguyen CUong', 'Cuong', '123', '4297f44b13955235245b2497399d7a93', '0787593574', 1),
(12, 'Dang Thanh', 'thanh27', 'Hcm', 'e35cf7b66449df565f93c607d5a81d09', 'qeuueue', 1),
(13, 'TerRon', 'fsterron', '123 Bà Điểm, Hóc Môn', 'e10adc3949ba59abbe56e057f20f883e', '0386403496', 1),
(14, 'dd', 'thanh25', 'ssd', 'e35cf7b66449df565f93c607d5a81d09', '0145768964', 1),
(16, 'User Test', 'khachhang1', 'hcm', 'e10adc3949ba59abbe56e057f20f883e', '0654154545', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_danhmuc`
--

CREATE TABLE `tbl_danhmuc` (
  `id_danhmuc` int NOT NULL,
  `tendanhmuc` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `thutu` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_danhmuc`
--

INSERT INTO `tbl_danhmuc` (`id_danhmuc`, `tendanhmuc`, `thutu`) VALUES
(9, 'Đồng hồ cao cấp', 2),
(10, 'Đồng hồ thương mại', 2),
(11, 'Đồng hồ nam', 3);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_order`
--

CREATE TABLE `tbl_order` (
  `id_order` int NOT NULL,
  `id_khachhang` int NOT NULL,
  `code_order` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `order_status` int NOT NULL,
  `order_date` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `order_payment` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `order_shipping` int NOT NULL,
  `ten_nguoi_nhan` varchar(100) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `sdt_nhan` varchar(20) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `dia_chi_nhan` varchar(200) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `ghi_chu_nhan` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_order`
--

INSERT INTO `tbl_order` (`id_order`, `id_khachhang`, `code_order`, `order_status`, `order_date`, `order_payment`, `order_shipping`, `ten_nguoi_nhan`, `sdt_nhan`, `dia_chi_nhan`, `ghi_chu_nhan`) VALUES
(11, 8, '9511', 3, '2026-02-26 12:41:49', 'tienmat', 2, 'thanh 25', '123456789', 'hcm', 'giao nhanh'),
(12, 10, '336', 3, '2026-03-26 05:09:26', 'chuyenkhoan', 5, 'kakashi12', '1231231231', '123123123', ''),
(13, 10, '83', 3, '2026-03-26 05:10:49', 'chuyenkhoan', 5, 'kakashi12', '1231231231', '123123123', ''),
(14, 10, '3663', 3, '2026-03-26 05:11:34', 'tienmat', 5, 'kakashi12', '1231231231', '123123123', ''),
(15, 10, '8583', 4, '2026-03-26 05:56:27', 'chuyenkhoan', 5, 'kakashi12', '1231231231', '123123123', ''),
(16, 10, '8852', 3, '2026-03-26 05:57:58', 'tienmat', 5, 'kakashi12', '1231231231', '123123123', ''),
(17, 10, '7835', 3, '2026-03-26 06:08:28', 'tienmat', 5, 'kakashi12', '1231231231', '123123123', ''),
(18, 10, '7058', 3, '2026-03-26 06:09:04', 'tienmat', 5, 'kakashi12', '1231231231', '123123123', ''),
(19, 8, '2660', 3, '2026-03-27 22:36:27', 'chuyenkhoan', 1, 'Đặng Thành', '123456789', 'hcm', 'giao nhanh'),
(20, 13, '4238', 2, '2026-03-28 13:25:44', 'tienmat', 1, 'TerRon', '0386403496', '123 Bà Điểm, Hóc Môn', ''),
(21, 13, '1656', 2, '2026-03-28 13:30:22', 'tienmat', 1, 'TerRon', '0386403496', '123 Bà Điểm, Hóc Môn', ''),
(22, 13, '8592', 3, '2026-03-28 13:30:47', 'tienmat', 1, 'TerRon', '0386403496', '123 Bà Điểm, Hóc Môn', ''),
(23, 13, '8481', 4, '2026-03-28 13:32:16', 'tienmat', 1, 'TerRon', '0386403496', '123 Bà Điểm, Hóc Môn', ''),
(24, 13, '4417', 2, '2026-03-28 13:34:21', 'tienmat', 1, 'TerRon', '0386403496', '123 Bà Điểm, Hóc Môn', ''),
(25, 13, '5315', 4, '2026-03-29 17:45:51', 'tienmat', 1, 'TerRon', '0386403496', '123 Bà Điểm, Hóc Môn', ''),
(26, 13, '1166', 1, '2026-03-29 21:02:04', 'tienmat', 1, 'TerRon', '0386403496', '123 Bà Điểm, Hóc Môn', ''),
(27, 13, '1952', 4, '2026-03-30 11:22:31', 'tienmat', 1, 'TerRon', '0386403496', '123 Bà Điểm, Hóc Môn', ''),
(28, 13, '5161', 3, '2026-03-30 11:53:08', 'tienmat', 1, 'TerRon', '0386403496', '123 Bà Điểm, Hóc Môn', ''),
(29, 13, '8827', 4, '2026-03-30 11:54:01', 'tienmat', 1, 'TerRon', '0386403496', '123 Bà Điểm, Hóc Môn', '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_order_details`
--

CREATE TABLE `tbl_order_details` (
  `id_order_details` int NOT NULL,
  `code_order` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `id_sanpham` int NOT NULL,
  `soluongmua` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_order_details`
--

INSERT INTO `tbl_order_details` (`id_order_details`, `code_order`, `id_sanpham`, `soluongmua`) VALUES
(12, '9511', 15, 2),
(13, '336', 13, 1),
(14, '336', 35, 1),
(15, '83', 35, 1),
(16, '3663', 35, 1),
(17, '8583', 35, 1),
(18, '8583', 21, 1),
(19, '8852', 35, 1),
(20, '7835', 21, 1),
(21, '7058', 21, 1),
(22, '2660', 35, 1),
(23, '4238', 35, 1),
(24, '1656', 35, 2),
(25, '8592', 35, 7),
(26, '8481', 33, 10),
(27, '4417', 29, 14),
(28, '5315', 37, 1),
(29, '1166', 37, 4),
(30, '1952', 34, 1),
(31, '5161', 34, 1),
(32, '8827', 34, 1),
(33, '8827', 28, 1),
(34, '8827', 32, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_phieunhap`
--

CREATE TABLE `tbl_phieunhap` (
  `id_phieunhap` int NOT NULL,
  `ma_phieunhap` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `ngay_nhap` datetime NOT NULL,
  `tinhtrang` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_phieunhap`
--

INSERT INTO `tbl_phieunhap` (`id_phieunhap`, `ma_phieunhap`, `ngay_nhap`, `tinhtrang`) VALUES
(1, 'PN1772089211', '2026-02-26 14:00:16', 1),
(2, 'PN1772089747', '2026-02-26 14:09:11', 1),
(6, 'PN1774795224', '2026-03-29 21:40:27', 0),
(7, 'PN1774943691', '2026-03-31 14:55:01', 1),
(8, 'PN1774943845', '2026-03-31 14:57:32', 0),
(9, 'PN1774943913', '2026-03-31 14:58:38', 1),
(10, 'PN1774943998', '2026-03-31 14:59:59', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_sanpham`
--

CREATE TABLE `tbl_sanpham` (
  `id_sanpham` int NOT NULL,
  `masp` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `tensp` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `giasp` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `soluong` int NOT NULL,
  `hinhanh` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `noidung` text COLLATE utf8mb4_general_ci NOT NULL,
  `tinhtrang` int NOT NULL,
  `id_danhmuc` int NOT NULL,
  `soluongban` int NOT NULL,
  `tyle_loinhuan` int DEFAULT '0',
  `donvitinh` varchar(50) COLLATE utf8mb4_general_ci DEFAULT '',
  `nhacungcap` varchar(100) COLLATE utf8mb4_general_ci DEFAULT '',
  `gianhap` float DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_sanpham`
--

INSERT INTO `tbl_sanpham` (`id_sanpham`, `masp`, `tensp`, `giasp`, `soluong`, `hinhanh`, `noidung`, `tinhtrang`, `id_danhmuc`, `soluongban`, `tyle_loinhuan`, `donvitinh`, `nhacungcap`, `gianhap`) VALUES
(11, '2', 'Đồng hồ nam 1', '32000', 5, '1771435575_Screenshot 2026-01-26 175334.png', 'hh', 0, 10, 0, 0, 'CÃ¡i', '', 32000),
(12, '1', 'Đồng hồ nam 2', '50000', 8, '1771435617_conan.jpg', 'gg', 0, 10, 0, 0, 'CÃ¡i', '', 50000),
(13, '5', 'Đồng hồ nam 3', '32000', 10, '1771435641_donghonam1.jpg', '', 0, 9, 1, 0, 'CÃ¡i', '', 32000),
(14, '5', 'Đồng hồ nam 5', '10000', 19, '1771682764_Screenshot 2025-10-31 082151.png', '5555', 0, 11, 0, 0, 'CÃ¡i', '', 10000),
(16, 'CAS01', 'Casio G-Shock GA-110', '3000000', 25, '1774226472_LX01.jpg', 'Đồng hồ phong cách thể thao mạnh mẽ.', 0, 11, 0, 20, 'Cái', 'Casio VN', 2500000),
(17, 'SEI01', 'Seiko 5 Automatic', '4500000', 15, '1774226473_LX02.jpg', 'Huyền thoại cơ bản của Seiko.', 0, 11, 0, 18, 'Cái', 'Seiko Global', 3800000),
(18, 'CAS02', 'Casio Edifice EFV', '4000000', 40, '1774226482_LX01.jpg', 'Phong cách thể thao, nam tính.', 0, 11, 0, 25, 'Cái', 'Casio VN', 3200000),
(19, 'SEI02', 'Seiko Prospex Diver', '9500000', 12, '1774226483_LX02.jpg', 'Đồng hồ lặn chuyên nghiệp từ Seiko.', 0, 11, 0, 17, 'Cái', 'Seiko Global', 8100000),
(20, 'FSL01', 'Fossil Grant Chronograph', '3800000', 25, '1774226472_LX01.jpg', 'Thời trang đậm chất Mỹ.', 0, 11, 0, 31, 'Cái', 'Fossil', 2900000),
(21, 'GSH56', 'Casio G-Shock Mudmaster', '7500000', 19, '1774226475_LX04.jpg', 'G-Shock chống bùn, siêu bền.', 0, 11, 3, 25, 'Cái', 'Casio VN', 6000000),
(22, 'ORI01', 'Orient Bambino Gen 2', '5500000', 30, '1774226475_LX04.jpg', 'Kính cong huyền thoại thanh lịch.', 0, 10, 0, 17, 'Cái', 'Orient', 4700000),
(23, 'CIT01', 'Citizen Eco-Drive', '6500000', 20, '1774226476_LX05.jpg', 'Chiếc đồng hồ sử dụng năng lượng ánh sáng độc đáo.', 0, 10, 0, 20, 'Cái', 'Citizen VN', 5400000),
(24, 'CIT02', 'Citizen Promaster', '8500000', 18, '1774226484_LX05.jpg', 'Vượt mọi thử thách khắc nghiệt.', 0, 10, 0, 21, 'Cái', 'Citizen VN', 7000000),
(25, 'DW001', 'Daniel Wellington Classic', '4500000', 50, '1774226485_LX08.jpg', 'Thời trang tối giản Scandinavian.', 0, 10, 0, 28, 'Cái', 'DW VN', 3500000),
(26, 'SKY01', 'Skagen Signatur', '3000000', 30, '1774226485_LX09.jpg', 'Thiết kế thanh mảnh, tối giản.', 0, 10, 0, 36, 'Cái', 'Skagen', 2200000),
(27, 'MKL01', 'Michael Kors Lexington', '5500000', 15, '1774226473_LX02.jpg', 'Sang trọng kiểu Mỹ, lấp lánh.', 0, 10, 0, 34, 'Cái', 'MK', 4100000),
(28, 'ROL01', 'Rolex Submariner Date', '250000000', 12, '1774226477_LX06.jpg', 'Huyền thoại không bao giờ lỗi thời.', 0, 9, 1, 25, 'Cái', 'Rolex', 200000000),
(29, 'OME01', 'Omega Seamaster 300M', '150000000', 1, '1774226478_LX07.jpg', 'Tuyệt phẩm từ Thụy Sĩ.', 0, 9, 14, 25, 'Cái', 'Omega', 120000000),
(30, 'TSS01', 'Tissot PRX Powermatic', '12000000', 32, '1774226479_LX08.jpg', 'Đỉnh cao thiết kế Retro-modern thập niên 70.', 0, 9, 0, 20, 'Cái', 'Tissot', 10000000),
(31, 'HUB01', 'Hublot Classic Fusion', '200000000', 14, '1774226480_LX09.jpg', 'Nghệ thuật hợp nhất cổ điển và hiện đại.', 0, 9, 0, 25, 'Cái', 'Hublot', 160000000),
(32, 'ORI02', 'Orient Star Classic', '14000000', 16, '1774226483_LX04.jpg', 'Sự lịch lãm tuyệt đối từ nhánh cao cấp của Orient.', 0, 9, 1, 27, 'Cái', 'Orient', 11000000),
(33, 'LNG01', 'Longines Master Collection', '221000000', 5, '1774226484_LX06.jpg', 'Hình ảnh di sản làm đồng hồ truyền thống lâu đời.', 0, 9, 10, 30, 'Cái', 'Longines', 170000000),
(34, 'FRC01', 'Frederique Constant', '61666625', 27, '1774226484_LX07.jpg', 'Phong cách độc lập thiết kế tại Thuỵ Sĩ.', 0, 9, 3, 25, 'Cái', '', 49333300);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_shipping`
--

CREATE TABLE `tbl_shipping` (
  `id_shipping` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `address` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `note` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `id_dangky` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_shipping`
--

INSERT INTO `tbl_shipping` (`id_shipping`, `name`, `phone`, `address`, `note`, `id_dangky`) VALUES
(2, 'Đặng Thành', '123456789', 'hcm', 'giao nhanh', 8),
(3, 'Đặng Thành', '123456789', 'hcm', 'giao nhanh', 8),
(4, 'thsnh', 'f', 'f', 'f', 9),
(5, 'kakashi12', '1231231231', '123123123', '', 10),
(6, 'TerRon', '0386403496', '123 Bà Điểm, Hóc Môn', '', 13);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Chỉ mục cho bảng `tbl_chitiet_phieunhap`
--
ALTER TABLE `tbl_chitiet_phieunhap`
  ADD PRIMARY KEY (`id_chitiet`),
  ADD KEY `id_phieunhap` (`id_phieunhap`);

--
-- Chỉ mục cho bảng `tbl_dangky`
--
ALTER TABLE `tbl_dangky`
  ADD PRIMARY KEY (`id_dangky`);

--
-- Chỉ mục cho bảng `tbl_danhmuc`
--
ALTER TABLE `tbl_danhmuc`
  ADD PRIMARY KEY (`id_danhmuc`);

--
-- Chỉ mục cho bảng `tbl_order`
--
ALTER TABLE `tbl_order`
  ADD PRIMARY KEY (`id_order`);

--
-- Chỉ mục cho bảng `tbl_order_details`
--
ALTER TABLE `tbl_order_details`
  ADD PRIMARY KEY (`id_order_details`);

--
-- Chỉ mục cho bảng `tbl_phieunhap`
--
ALTER TABLE `tbl_phieunhap`
  ADD PRIMARY KEY (`id_phieunhap`);

--
-- Chỉ mục cho bảng `tbl_sanpham`
--
ALTER TABLE `tbl_sanpham`
  ADD PRIMARY KEY (`id_sanpham`);

--
-- Chỉ mục cho bảng `tbl_shipping`
--
ALTER TABLE `tbl_shipping`
  ADD PRIMARY KEY (`id_shipping`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id_admin` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `tbl_chitiet_phieunhap`
--
ALTER TABLE `tbl_chitiet_phieunhap`
  MODIFY `id_chitiet` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `tbl_dangky`
--
ALTER TABLE `tbl_dangky`
  MODIFY `id_dangky` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT cho bảng `tbl_danhmuc`
--
ALTER TABLE `tbl_danhmuc`
  MODIFY `id_danhmuc` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `tbl_order`
--
ALTER TABLE `tbl_order`
  MODIFY `id_order` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT cho bảng `tbl_order_details`
--
ALTER TABLE `tbl_order_details`
  MODIFY `id_order_details` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT cho bảng `tbl_phieunhap`
--
ALTER TABLE `tbl_phieunhap`
  MODIFY `id_phieunhap` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `tbl_sanpham`
--
ALTER TABLE `tbl_sanpham`
  MODIFY `id_sanpham` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT cho bảng `tbl_shipping`
--
ALTER TABLE `tbl_shipping`
  MODIFY `id_shipping` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `tbl_chitiet_phieunhap`
--
ALTER TABLE `tbl_chitiet_phieunhap`
  ADD CONSTRAINT `tbl_chitiet_phieunhap_ibfk_1` FOREIGN KEY (`id_phieunhap`) REFERENCES `tbl_phieunhap` (`id_phieunhap`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
