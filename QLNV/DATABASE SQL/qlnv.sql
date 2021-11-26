-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 24, 2021 at 01:15 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `qlnv`
--

-- --------------------------------------------------------

DROP DATABASE IF EXISTS `qlnv`;
CREATE DATABASE `qlnv` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `qlnv`;

--
-- Table structure for table `loainv`
--

CREATE TABLE `loainv` (
  `MaLoaiNV` int(10) UNSIGNED NOT NULL,
  `TenLoaiNV` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `loainv`
--

INSERT INTO `loainv` (`MaLoaiNV`, `TenLoaiNV`) VALUES
(1, 'Trưởng phòng'),
(2, 'Saler'),
(3, 'Kế toán'),
(4, 'Thư ký'),
(5, 'Nhân viên'),
(6, 'Chủ tịch hội đồng'),
(7, 'Tổng giám đốc'),
(8, 'Giám đốc'),
(9, 'Quản lý'),
(10, 'Nhân viên sale cấp cao'),
(11, 'Trưởng nhóm thiết kế mẫu sản phẩm'),
(12, 'NV xử lý chất thải');

-- --------------------------------------------------------

--
-- Table structure for table `nhanvien`
--

CREATE TABLE `nhanvien` (
  `MaNV` int(10) UNSIGNED NOT NULL,
  `Ho` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Ten` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `NgaySinh` date NOT NULL,
  `GioiTinh` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `DiaChi` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Anh` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `MaLoaiNV` int(10) UNSIGNED NOT NULL,
  `MaPhong` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `nhanvien`
--

INSERT INTO `nhanvien` (`MaNV`, `Ho`, `Ten`, `NgaySinh`, `GioiTinh`, `DiaChi`, `Anh`, `MaLoaiNV`, `MaPhong`) VALUES
(1, 'Nguyễn Văn', 'Tuấn', '1991-10-09', 'Nam', 'Số 9, Ngô đến', '6.png', 1, 3),
(2, 'Nguyễn Văn', 'Thắng', '1993-10-20', 'Nam', 'Số 12, Vạn Thắng', '3.png', 8, 2),
(3, 'Lê Thị', 'Linh', '1995-10-10', 'Nữ', 'Số 99, Hoàng Diệu, Nha Trang', '4.png', 4, 6),
(4, 'Hoàng Mỹ', 'Thắm', '1999-10-08', 'Nữ', 'Số 65, Lê Quý Đôn', '5.png', 2, 2),
(5, 'Nguyễn Mỹ', 'Tiên', '2001-10-05', 'Nữ', 'Số 1, Vạn Trường', '2.png', 5, 4),
(6, 'Nguyễn Tuấn', 'Anh', '1994-10-13', 'Nam', 'Số 63, Ngô Đến', '1.png', 6, 5),
(7, 'Cao Đinh', 'La', '1995-10-04', 'Nam', 'Số 99, Hoàng Hoa Thám', '1.png', 5, 5),
(8, 'Đặng Tuyết', 'Nhung', '1998-10-15', 'Nữ', 'Ngã tư, Cầu Bóng', '3.png', 2, 2),
(11, 'Lê Văn', 'Mận', '1999-06-17', 'Nữ', '09 Hoàng Văn Thụ', '2.png', 2, 5),
(13, 'Lê Hoàng', 'Kiều', '1998-06-17', 'Nữ', '03 Phú Bằng', '2.png', 4, 5),
(14, 'Hoàng Văn', 'Đại', '1993-01-12', 'Nam', '45 Lạng Sơn', '3.png', 6, 3),
(17, 'Lê Hoàng', 'Thu', '1988-01-12', 'Nữ', '12, Thu Đến', 'wf2.jpg', 4, 1),
(18, 'Nguyễn Thị', 'Thu', '1996-02-22', 'Nữ', '12, Cao Bằng, Thái Nguyên', 'anhnv.png', 9, 5),
(21, 'Cao Bá', 'Quát', '1999-12-02', 'Nam', '18, Hoàng Sơn', 'wf2.jpg', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `phongban`
--

CREATE TABLE `phongban` (
  `MaPhong` int(10) UNSIGNED NOT NULL,
  `TenPhong` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `phongban`
--

INSERT INTO `phongban` (`MaPhong`, `TenPhong`) VALUES
(1, 'Đảm bảo chất lượng'),
(2, 'Ngoại giao'),
(3, 'Quản trị'),
(4, 'Kỹ thuật'),
(5, 'Ký túc xá'),
(6, 'Hỗ trợ khách hàng'),
(7, 'Nghiên cứu thị trường'),
(9, 'Giám sát vận hành kỹ thuật'),
(10, 'Xử lý khí thải');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `loainv`
--
ALTER TABLE `loainv`
  ADD PRIMARY KEY (`MaLoaiNV`);

--
-- Indexes for table `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD PRIMARY KEY (`MaNV`),
  ADD KEY `MaLoaiNV` (`MaLoaiNV`),
  ADD KEY `MaPhong` (`MaPhong`);

--
-- Indexes for table `phongban`
--
ALTER TABLE `phongban`
  ADD PRIMARY KEY (`MaPhong`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `loainv`
--
ALTER TABLE `loainv`
  MODIFY `MaLoaiNV` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `nhanvien`
--
ALTER TABLE `nhanvien`
  MODIFY `MaNV` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `phongban`
--
ALTER TABLE `phongban`
  MODIFY `MaPhong` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD CONSTRAINT `nhanvien_ibfk_1` FOREIGN KEY (`MaPhong`) REFERENCES `phongban` (`MaPhong`),
  ADD CONSTRAINT `nhanvien_ibfk_2` FOREIGN KEY (`MaLoaiNV`) REFERENCES `loainv` (`MaLoaiNV`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
