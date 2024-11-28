-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 27, 2024 at 09:14 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_nhom17it8`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `ADMIN_MaNV` int(100) NOT NULL,
  `ADMIN_MaTaiKhoan` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`ADMIN_MaNV`, `ADMIN_MaTaiKhoan`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `chitietlichtrinh`
--

CREATE TABLE `chitietlichtrinh` (
  `MaChiTiet` int(100) NOT NULL,
  `LT_MaLichTrinh` int(100) NOT NULL,
  `GT_MaGaTau` int(11) NOT NULL,
  `ThoiGianDen` time NOT NULL,
  `ThoiGianDi` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chitietlichtrinh`
--

INSERT INTO `chitietlichtrinh` (`MaChiTiet`, `LT_MaLichTrinh`, `GT_MaGaTau`, `ThoiGianDen`, `ThoiGianDi`) VALUES
(1, 1, 10, '21:55:00', '21:55:00'),
(2, 1, 9, '01:05:00', '01:10:00'),
(3, 1, 8, '04:45:00', '05:00:00'),
(4, 1, 7, '13:35:00', '13:55:00'),
(5, 1, 6, '16:20:00', '16:30:00'),
(6, 1, 5, '19:20:00', '19:40:00'),
(7, 1, 4, '23:35:00', '23:40:00'),
(8, 1, 3, '02:15:00', '02:20:00'),
(9, 1, 2, '03:50:00', '03:55:00'),
(10, 1, 1, '05:30:00', '05:30:00'),
(11, 2, 1, '21:55:00', '21:55:00'),
(12, 2, 2, '00:50:00', '01:00:00'),
(13, 2, 3, '02:30:00', '02:35:00'),
(14, 2, 4, '06:00:00', '06:10:00'),
(15, 2, 5, '10:00:00', '10:10:00'),
(16, 2, 6, '13:10:00', '13:15:00'),
(17, 2, 7, '15:30:00', '15:40:00'),
(18, 2, 8, '00:10:00', '00:30:00'),
(19, 2, 9, '03:50:00', '03:55:00'),
(20, 2, 10, '05:30:00', '05:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `chuyentau`
--

CREATE TABLE `chuyentau` (
  `CT_Ma` int(100) NOT NULL,
  `CT_MaTau` varchar(10) NOT NULL,
  `CT_MaLichTrinh` int(11) NOT NULL,
  `CT_DiemKhoiHanh` varchar(100) NOT NULL,
  `CT_DiemKetThuc` varchar(100) NOT NULL,
  `CT_SoVeDaDat` int(100) NOT NULL,
  `CT_NgayKhoiHanh` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chuyentau`
--

INSERT INTO `chuyentau` (`CT_Ma`, `CT_MaTau`, `CT_MaLichTrinh`, `CT_DiemKhoiHanh`, `CT_DiemKetThuc`, `CT_SoVeDaDat`, `CT_NgayKhoiHanh`) VALUES
(1, 'SE2', 2, 'Hà Nội', 'Sài Gòn', 0, '2024-01-11 16:48:20');

-- --------------------------------------------------------

--
-- Table structure for table `gatau`
--

CREATE TABLE `gatau` (
  `GT_MaGaTau` int(100) NOT NULL,
  `GT_Ten` varchar(100) NOT NULL,
  `GT_CuLy` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gatau`
--

INSERT INTO `gatau` (`GT_MaGaTau`, `GT_Ten`, `GT_CuLy`) VALUES
(1, 'Hà Nội', 0),
(2, 'Nam Định', 87),
(3, 'Thanh Hóa', 175),
(4, 'Vinh', 319),
(5, 'Đồng Hới', 522),
(6, 'Huế', 688),
(7, 'Đà Nẵng', 791),
(8, 'Nha Trang', 1315),
(9, 'Long Khánh', 1649),
(10, 'Sài Gòn', 1726);

-- --------------------------------------------------------

--
-- Table structure for table `khachhang`
--

CREATE TABLE `khachhang` (
  `KH_Ma` int(100) NOT NULL,
  `KH_MaTaiKhoan` int(11) NOT NULL,
  `KH_Ten` varchar(100) NOT NULL,
  `KH_GioiTinh` varchar(10) DEFAULT NULL,
  `KH_NgaySinh` date DEFAULT NULL,
  `KH_SDT` varchar(13) NOT NULL,
  `KH_Email` varchar(100) NOT NULL,
  `KH_DiaChi` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `khachhang`
--

INSERT INTO `khachhang` (`KH_Ma`, `KH_MaTaiKhoan`, `KH_Ten`, `KH_GioiTinh`, `KH_NgaySinh`, `KH_SDT`, `KH_Email`, `KH_DiaChi`) VALUES
(1, 4, 'Tran Dinh Tuyen', 'Nam', '2003-01-18', '09738288419', 'anhtuyen@gmail.com', 'Hai Duong'),
(2, 5, 'Bui Cong Dat', 'Nam', '2000-10-01', '0983782742', 'datcongh43@gmail.com', 'Hai Duong');

-- --------------------------------------------------------

--
-- Table structure for table `khoangtau`
--

CREATE TABLE `khoangtau` (
  `KHOANG_Ma` int(100) NOT NULL,
  `KHOANG_MaTau` varchar(10) NOT NULL,
  `KHOANG_Ten` varchar(50) NOT NULL,
  `KHOANG_LoaiKhoang` varchar(50) NOT NULL,
  `KHOANG_SoGhe` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `khoangtau`
--

INSERT INTO `khoangtau` (`KHOANG_Ma`, `KHOANG_MaTau`, `KHOANG_Ten`, `KHOANG_LoaiKhoang`, `KHOANG_SoGhe`) VALUES
(1, 'SE2', 'Khoang 1', 'Ghế thường', 64),
(2, 'SE2', 'Khoang 2 VIP', 'Ghế nằm 4', 28),
(3, 'SE2', 'Khoang 3 VIP', 'Ghế nằm 6', 42),
(4, 'SE4', 'Khoang 1', 'Ghế thường ', 64),
(5, 'SE4', 'Khoang 2 VIP', 'Ghế nằm 4', 28),
(6, 'SE4', 'Khoang 3 VIP', 'Ghế nằm 6 ', 42),
(7, 'SE6', 'Khoang 1', 'Ghế thường', 64),
(8, 'SE6', 'Khoang 2', 'Ghế thường', 80),
(9, 'SE6', 'Khoang 3 VIP', 'Ghế nằm 4', 28),
(10, 'SE6', 'Khoang 4 VIP', 'Ghế nằm 6', 42);

-- --------------------------------------------------------

--
-- Table structure for table `lichtrinh`
--

CREATE TABLE `lichtrinh` (
  `LT_MaLichTrinh` int(100) NOT NULL,
  `LT_TenLichTrinh` varchar(100) NOT NULL,
  `LT_DiemXuatPhat` varchar(100) NOT NULL,
  `LT_DiemDen` varchar(100) NOT NULL,
  `LT_ThoiGianDuKien` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lichtrinh`
--

INSERT INTO `lichtrinh` (`LT_MaLichTrinh`, `LT_TenLichTrinh`, `LT_DiemXuatPhat`, `LT_DiemDen`, `LT_ThoiGianDuKien`) VALUES
(1, 'Nam - Bắc (đi đêm)', 'Sài Gòn', 'Hà Nội', '2 ngày rưỡi'),
(2, 'Bắc - Nam (đi đêm)', 'Hà Nội', 'Sài Gòn', '2 ngày rưỡi');

-- --------------------------------------------------------

--
-- Table structure for table `nhanvien`
--

CREATE TABLE `nhanvien` (
  `NV_Ma` int(100) NOT NULL,
  `NV_MaTaiKhoan` int(100) NOT NULL,
  `NV_Ten` varchar(100) NOT NULL,
  `NV_GioiTinh` varchar(10) NOT NULL,
  `NV_SDT` varchar(13) NOT NULL,
  `NV_DiaChi` varchar(100) NOT NULL,
  `NV_ChucVu` varchar(50) NOT NULL,
  `NV_LuongThang` decimal(19,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nhanvien`
--

INSERT INTO `nhanvien` (`NV_Ma`, `NV_MaTaiKhoan`, `NV_Ten`, `NV_GioiTinh`, `NV_SDT`, `NV_DiaChi`, `NV_ChucVu`, `NV_LuongThang`) VALUES
(1, 1, 'Trần Đình Tuyến', 'Nam', '0963421148', 'Hải Dương', 'Quản lý', 100.00),
(2, 3, 'Bùi Công Đạt', 'Nam', '0983728471', 'Hải Dương', 'Nhân viên trực web', 100.00),
(3, 2, 'Lê Văn Hùng', 'Nam', '0283716273', 'Thanh Hóa', 'Nhân viên trực web', 100000.00);

-- --------------------------------------------------------

--
-- Table structure for table `taikhoan`
--

CREATE TABLE `taikhoan` (
  `TK_MaTaiKhoan` int(100) NOT NULL,
  `TK_TenDangNhap` varchar(100) NOT NULL,
  `TK_MatKhau` varchar(100) NOT NULL,
  `TK_PhanQuyen` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `taikhoan`
--

INSERT INTO `taikhoan` (`TK_MaTaiKhoan`, `TK_TenDangNhap`, `TK_MatKhau`, `TK_PhanQuyen`) VALUES
(1, 'admin', '1234', 'admin'),
(2, 'nv1', '1234', 'nhanvien'),
(3, 'nv2', '12345', 'nhanvien'),
(4, 'kh1', '1234', 'khachhang'),
(5, 'kh2', '1234', 'khachhang'),
(20, 'trandinhtuyen18', 'anhtuyen2003', 'khachhang');

-- --------------------------------------------------------

--
-- Table structure for table `tau`
--

CREATE TABLE `tau` (
  `TAU_MaTau` varchar(10) NOT NULL,
  `TAU_TinhTrang` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tau`
--

INSERT INTO `tau` (`TAU_MaTau`, `TAU_TinhTrang`) VALUES
('SE2', 'Hoạt động bình thường'),
('SE4', 'Hoạt động bình thường'),
('SE6', 'Hoạt động bình thường');

-- --------------------------------------------------------

--
-- Table structure for table `vetau`
--

CREATE TABLE `vetau` (
  `VT_MaVeTau` int(255) NOT NULL,
  `VT_MaChuyenTau` int(100) NOT NULL,
  `VT_MaKhoang` int(100) NOT NULL,
  `VT_MaKH` int(100) DEFAULT NULL,
  `VT_MaNV` int(100) DEFAULT NULL,
  `VT_DiemDi` varchar(100) NOT NULL,
  `VT_DiemDen` varchar(100) NOT NULL,
  `VT_GheSo` int(100) NOT NULL,
  `VT_NgayDat` datetime NOT NULL,
  `VT_NgayKhoiHanh` datetime NOT NULL,
  `VT_Gia` decimal(19,2) NOT NULL,
  `VT_TrangThai` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vetau`
--

INSERT INTO `vetau` (`VT_MaVeTau`, `VT_MaChuyenTau`, `VT_MaKhoang`, `VT_MaKH`, `VT_MaNV`, `VT_DiemDi`, `VT_DiemDen`, `VT_GheSo`, `VT_NgayDat`, `VT_NgayKhoiHanh`, `VT_Gia`, `VT_TrangThai`) VALUES
(427, 1, 1, NULL, 1, 'Hà Nội', 'Huế', 12, '2024-01-28 15:11:00', '2024-01-29 15:11:00', 300000.00, 'Đã thanh toán'),
(428, 1, 1, 1, NULL, 'Hà Nội', 'Vinh', 8, '2024-01-27 15:12:00', '2024-01-28 05:30:00', 200000.00, 'Đã thanh toán'),
(429, 1, 1, 1, NULL, 'Hà Nội', 'Vinh', 16, '2024-01-27 15:12:00', '2024-01-28 05:30:00', 200000.00, 'Đã thanh toán');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD KEY `FK_ADMIN_NHANVIEN` (`ADMIN_MaNV`),
  ADD KEY `FK_ADMIN_TAIKHOAN` (`ADMIN_MaTaiKhoan`);

--
-- Indexes for table `chitietlichtrinh`
--
ALTER TABLE `chitietlichtrinh`
  ADD PRIMARY KEY (`MaChiTiet`),
  ADD KEY `FK_chitiet_lichtrinh` (`LT_MaLichTrinh`),
  ADD KEY `FK_chitiet_gatau` (`GT_MaGaTau`);

--
-- Indexes for table `chuyentau`
--
ALTER TABLE `chuyentau`
  ADD PRIMARY KEY (`CT_Ma`),
  ADD KEY `FK_chuyentau_tau` (`CT_MaTau`),
  ADD KEY `FK_chuyentau_lichtrinh` (`CT_MaLichTrinh`);

--
-- Indexes for table `gatau`
--
ALTER TABLE `gatau`
  ADD PRIMARY KEY (`GT_MaGaTau`);

--
-- Indexes for table `khachhang`
--
ALTER TABLE `khachhang`
  ADD PRIMARY KEY (`KH_Ma`),
  ADD KEY `FK_khachhang_taikhoan` (`KH_MaTaiKhoan`);

--
-- Indexes for table `khoangtau`
--
ALTER TABLE `khoangtau`
  ADD PRIMARY KEY (`KHOANG_Ma`),
  ADD KEY `FK_khoangtau_tau` (`KHOANG_MaTau`);

--
-- Indexes for table `lichtrinh`
--
ALTER TABLE `lichtrinh`
  ADD PRIMARY KEY (`LT_MaLichTrinh`);

--
-- Indexes for table `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD PRIMARY KEY (`NV_Ma`),
  ADD KEY `FK_nhanvien_taikhoan` (`NV_MaTaiKhoan`);

--
-- Indexes for table `taikhoan`
--
ALTER TABLE `taikhoan`
  ADD PRIMARY KEY (`TK_MaTaiKhoan`),
  ADD UNIQUE KEY `idx_TK_TenDangNhap` (`TK_TenDangNhap`);

--
-- Indexes for table `tau`
--
ALTER TABLE `tau`
  ADD PRIMARY KEY (`TAU_MaTau`);

--
-- Indexes for table `vetau`
--
ALTER TABLE `vetau`
  ADD PRIMARY KEY (`VT_MaVeTau`),
  ADD KEY `FK_vetau_chuyentau` (`VT_MaChuyenTau`),
  ADD KEY `FK_vetau_khoangtau` (`VT_MaKhoang`),
  ADD KEY `FK_vetau_nhanvien` (`VT_MaNV`),
  ADD KEY `FK_vetau_khachhang` (`VT_MaKH`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chuyentau`
--
ALTER TABLE `chuyentau`
  MODIFY `CT_Ma` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `gatau`
--
ALTER TABLE `gatau`
  MODIFY `GT_MaGaTau` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `khachhang`
--
ALTER TABLE `khachhang`
  MODIFY `KH_Ma` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `khoangtau`
--
ALTER TABLE `khoangtau`
  MODIFY `KHOANG_Ma` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `lichtrinh`
--
ALTER TABLE `lichtrinh`
  MODIFY `LT_MaLichTrinh` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `nhanvien`
--
ALTER TABLE `nhanvien`
  MODIFY `NV_Ma` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `taikhoan`
--
ALTER TABLE `taikhoan`
  MODIFY `TK_MaTaiKhoan` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `vetau`
--
ALTER TABLE `vetau`
  MODIFY `VT_MaVeTau` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=430;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `FK_ADMIN_NHANVIEN` FOREIGN KEY (`ADMIN_MaNV`) REFERENCES `nhanvien` (`NV_Ma`),
  ADD CONSTRAINT `FK_ADMIN_TAIKHOAN` FOREIGN KEY (`ADMIN_MaTaiKhoan`) REFERENCES `taikhoan` (`TK_MaTaiKhoan`);

--
-- Constraints for table `chitietlichtrinh`
--
ALTER TABLE `chitietlichtrinh`
  ADD CONSTRAINT `FK_chitiet_gatau` FOREIGN KEY (`GT_MaGaTau`) REFERENCES `gatau` (`GT_MaGaTau`),
  ADD CONSTRAINT `FK_chitiet_lichtrinh` FOREIGN KEY (`LT_MaLichTrinh`) REFERENCES `lichtrinh` (`LT_MaLichTrinh`);

--
-- Constraints for table `chuyentau`
--
ALTER TABLE `chuyentau`
  ADD CONSTRAINT `FK_chuyentau_lichtrinh` FOREIGN KEY (`CT_MaLichTrinh`) REFERENCES `lichtrinh` (`LT_MaLichTrinh`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_chuyentau_tau` FOREIGN KEY (`CT_MaTau`) REFERENCES `tau` (`TAU_MaTau`) ON UPDATE CASCADE;

--
-- Constraints for table `khachhang`
--
ALTER TABLE `khachhang`
  ADD CONSTRAINT `FK_khachhang_taikhoan` FOREIGN KEY (`KH_MaTaiKhoan`) REFERENCES `taikhoan` (`TK_MaTaiKhoan`);

--
-- Constraints for table `khoangtau`
--
ALTER TABLE `khoangtau`
  ADD CONSTRAINT `FK_khoangtau_tau` FOREIGN KEY (`KHOANG_MaTau`) REFERENCES `tau` (`TAU_MaTau`);

--
-- Constraints for table `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD CONSTRAINT `FK_nhanvien_taikhoan` FOREIGN KEY (`NV_MaTaiKhoan`) REFERENCES `taikhoan` (`TK_MaTaiKhoan`);

--
-- Constraints for table `vetau`
--
ALTER TABLE `vetau`
  ADD CONSTRAINT `FK_vetau_chuyentau` FOREIGN KEY (`VT_MaChuyenTau`) REFERENCES `chuyentau` (`CT_Ma`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_vetau_khachhang` FOREIGN KEY (`VT_MaKH`) REFERENCES `khachhang` (`KH_Ma`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_vetau_khoangtau` FOREIGN KEY (`VT_MaKhoang`) REFERENCES `khoangtau` (`KHOANG_Ma`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_vetau_nhanvien` FOREIGN KEY (`VT_MaNV`) REFERENCES `nhanvien` (`NV_Ma`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
