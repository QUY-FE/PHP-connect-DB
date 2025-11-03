<?php
$host = 'localhost';
$userName = 'root';
$password = '';
$dbName = 'qly_sinh_vien';

try {
    // Kết nối MySQL không có database
    $pdo = new PDO("mysql:host=$host", $userName, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Tạo database nếu chưa tồn tại
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $pdo->exec("USE `$dbName`");
    
    // Tạo bảng sinhvien nếu chưa tồn tại
    $sql = "CREATE TABLE IF NOT EXISTS `sinhvien` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `ma_sv` varchar(20) NOT NULL,
        `hoten` varchar(50) NOT NULL,
        `lop` varchar(20) NOT NULL,
        `chuyen_nganh` varchar(50) NOT NULL,
        `gioitinh` enum('Nam','Nữ','Khác') NOT NULL,
        `ngaysinh` date DEFAULT NULL,
        `sdt` varchar(15) DEFAULT NULL,
        `email` varchar(50) DEFAULT NULL,
        `GPA` decimal(3,2) DEFAULT NULL,
        `diachi` varchar(200) NOT NULL,
        `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
        `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        UNIQUE KEY `ma_sv` (`ma_sv`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $pdo->exec($sql);

} catch (\PDOException $e) {
    die('Lỗi kết nối/khởi tạo DB: ' . $e->getMessage());
}
