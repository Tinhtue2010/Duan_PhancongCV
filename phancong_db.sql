-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Mar 16, 2025 at 08:03 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phancong_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `bo_phan`
--

CREATE TABLE `bo_phan` (
  `ma_bo_phan` varchar(10) NOT NULL,
  `ten_bo_phan` varchar(255) NOT NULL,
  `chuc_nang_nhiem_vu` varchar(255) DEFAULT NULL,
  `thoi_gian_thanh_lap` date DEFAULT NULL,
  `thoi_gian_giai_the` date DEFAULT NULL,
  `trang_thai` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bo_phan`
--

INSERT INTO `bo_phan` (`ma_bo_phan`, `ten_bo_phan`, `chuc_nang_nhiem_vu`, `thoi_gian_thanh_lap`, `thoi_gian_giai_the`, `trang_thai`) VALUES
('BP01', '123', '345', '2025-03-11', '2025-03-14', '1');

--
-- Triggers `bo_phan`
--
DELIMITER $$
CREATE TRIGGER `before_insert_bo_phan` BEFORE INSERT ON `bo_phan` FOR EACH ROW BEGIN
    DECLARE next_id INT;
    DECLARE next_ma VARCHAR(10);

    -- Get the numeric part of the last inserted ID
    SELECT COALESCE(MAX(CAST(SUBSTRING(ma_bo_phan, 2) AS UNSIGNED)), 0) + 1 
    INTO next_id FROM bo_phan;

    SET next_ma = CONCAT('BP', LPAD(next_id, 2, '0'));

    -- Assign the generated ID
    SET NEW.ma_bo_phan = next_ma;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `can_bo`
--

CREATE TABLE `can_bo` (
  `ma_can_bo` varchar(10) NOT NULL,
  `ma_bo_phan` varchar(50) DEFAULT NULL,
  `ten_can_bo` varchar(255) NOT NULL,
  `chuc_danh` varchar(50) DEFAULT NULL,
  `trang_thai` tinyint(4) NOT NULL,
  `ma_tai_khoan` int(11) NOT NULL,
  `nhom_vi_tri_lam_viec` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `can_bo`
--

INSERT INTO `can_bo` (`ma_can_bo`, `ma_bo_phan`, `ten_can_bo`, `chuc_danh`, `trang_thai`, `ma_tai_khoan`, `nhom_vi_tri_lam_viec`) VALUES
('HQ001', 'BP01', 'Trần Đạt a', '5', 1, 2, '');

--
-- Triggers `can_bo`
--
DELIMITER $$
CREATE TRIGGER `before_insert_can_bo` BEFORE INSERT ON `can_bo` FOR EACH ROW BEGIN
    DECLARE next_id INT;
    DECLARE next_ma VARCHAR(10);

    -- Get the numeric part of the last inserted ID
    SELECT COALESCE(MAX(CAST(SUBSTRING(ma_can_bo, 3) AS UNSIGNED)), 0) + 1 INTO next_id FROM can_bo;

    -- Format it as HQxxx (e.g., HQ001, HQ002)
    SET next_ma = CONCAT('HQ', LPAD(next_id, 3, '0'));

    -- Assign the generated ID
    SET NEW.ma_can_bo = next_ma;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `cong_viec`
--

CREATE TABLE `cong_viec` (
  `ma_cong_viec` int(11) DEFAULT NULL,
  `ten_cong_viec` varchar(255) NOT NULL,
  `ma_bo_phan` varchar(50) NOT NULL,
  `loai_cong_viec` varchar(50) NOT NULL,
  `ma_thoi_han` int(11) NOT NULL,
  `trang_thai` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dieu_chuyen`
--

CREATE TABLE `dieu_chuyen` (
  `ma_dieu_chuyen` int(11) NOT NULL,
  `ma_can_bo` varchar(50) NOT NULL,
  `thoi_gian_dieu_chuyen` date NOT NULL,
  `ma_bo_phan_chuyen_den` varchar(50) NOT NULL,
  `chuc_danh_moi` varchar(50) NOT NULL,
  `ly_do` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nghi_phep`
--

CREATE TABLE `nghi_phep` (
  `ma_nghi_phep` int(11) NOT NULL,
  `ma_can_bo` varchar(50) NOT NULL,
  `ngay_lam_viec` date DEFAULT NULL,
  `tu_gio` varchar(50) DEFAULT NULL,
  `den_gio` varchar(50) DEFAULT NULL,
  `ngay_bat_dau` date NOT NULL,
  `ngay_ket_thuc` date NOT NULL,
  `ly_do_vang` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `phan_cong`
--

CREATE TABLE `phan_cong` (
  `ma_phan_cong` int(11) NOT NULL,
  `ma_cong_viec` int(11) NOT NULL,
  `ma_can_bo_giao` varchar(50) NOT NULL,
  `ma_can_bo_nhan` varchar(50) NOT NULL,
  `ngay_phan_cong` date DEFAULT NULL,
  `ngay_nhan_viec` date DEFAULT NULL,
  `chi_tiet` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tai_khoan`
--

CREATE TABLE `tai_khoan` (
  `ma_tai_khoan` int(11) NOT NULL,
  `ten_dang_nhap` varchar(50) NOT NULL,
  `mat_khau` varchar(255) NOT NULL,
  `quyen_han` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tai_khoan`
--

INSERT INTO `tai_khoan` (`ma_tai_khoan`, `ten_dang_nhap`, `mat_khau`, `quyen_han`) VALUES
(1, 'admin', '$2y$12$EUy8w7SYfGF0gTaKFgzcLuHkZr1LkTPE4TdLmO8Vw.gPvctXcNfea', 'Admin'),
(2, 'dat123', '$2y$12$ccQ33n5.BqoYc3MqJg.wBe9Rf3yWjvmI01RcDDNpKw2l920m7O9d6', 'Cán bộ'),
(3, '0102345275', '$2y$12$CgdJPbjlRwrM8ff/y81L2.Ec5qdKziR9BcpwuCMUvp2UwWldFG2ey', 'Cán bộ');

-- --------------------------------------------------------

--
-- Table structure for table `thoi_han_hoan_thanh`
--

CREATE TABLE `thoi_han_hoan_thanh` (
  `ma_thoi_han` int(11) NOT NULL,
  `ma_cong_viec` int(11) NOT NULL,
  `moc_thoi_gian` varchar(255) DEFAULT NULL,
  `ngay_het_han` varchar(50) DEFAULT NULL,
  `thang_het_han` varchar(50) DEFAULT NULL,
  `noi_nhan` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bo_phan`
--
ALTER TABLE `bo_phan`
  ADD PRIMARY KEY (`ma_bo_phan`);

--
-- Indexes for table `can_bo`
--
ALTER TABLE `can_bo`
  ADD PRIMARY KEY (`ma_can_bo`);

--
-- Indexes for table `dieu_chuyen`
--
ALTER TABLE `dieu_chuyen`
  ADD PRIMARY KEY (`ma_dieu_chuyen`);

--
-- Indexes for table `nghi_phep`
--
ALTER TABLE `nghi_phep`
  ADD PRIMARY KEY (`ma_nghi_phep`);

--
-- Indexes for table `phan_cong`
--
ALTER TABLE `phan_cong`
  ADD PRIMARY KEY (`ma_phan_cong`);

--
-- Indexes for table `tai_khoan`
--
ALTER TABLE `tai_khoan`
  ADD PRIMARY KEY (`ma_tai_khoan`);

--
-- Indexes for table `thoi_han_hoan_thanh`
--
ALTER TABLE `thoi_han_hoan_thanh`
  ADD PRIMARY KEY (`ma_thoi_han`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dieu_chuyen`
--
ALTER TABLE `dieu_chuyen`
  MODIFY `ma_dieu_chuyen` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nghi_phep`
--
ALTER TABLE `nghi_phep`
  MODIFY `ma_nghi_phep` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phan_cong`
--
ALTER TABLE `phan_cong`
  MODIFY `ma_phan_cong` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tai_khoan`
--
ALTER TABLE `tai_khoan`
  MODIFY `ma_tai_khoan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `thoi_han_hoan_thanh`
--
ALTER TABLE `thoi_han_hoan_thanh`
  MODIFY `ma_thoi_han` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
