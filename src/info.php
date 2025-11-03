
<?php
require_once 'connect.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    die('ID không hợp lệ');
}

try {
    $sql = "SELECT * FROM sinhvien WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$data) {
        die('Không tìm thấy sinh viên');
    }
} catch (PDOException $e) {
    die('Lỗi truy vấn: ' . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin sinh viên</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="student-info">
        <h1 class="student-info__title">Thông tin chi tiết sinh viên</h1>
        
        <div class="student-info__card">
            <div class="student-info__field">
                <label class="student-info__label">Mã sinh viên:</label>
                <span class="student-info__value"><?= htmlspecialchars($data['ma_sv']) ?></span>
            </div>

            <div class="student-info__field">
                <label class="student-info__label">Họ và tên:</label>
                <span class="student-info__value"><?= htmlspecialchars($data['hoten']) ?></span>
            </div>

            <div class="student-info__field">
                <label class="student-info__label">Lớp:</label>
                <span class="student-info__value"><?= htmlspecialchars($data['lop']) ?></span>
            </div>

            <div class="student-info__field">
                <label class="student-info__label">Chuyên ngành:</label>
                <span class="student-info__value"><?= htmlspecialchars($data['chuyen_nganh']) ?></span>
            </div>

            <div class="student-info__field">
                <label class="student-info__label">Giới tính:</label>
                <span class="student-info__value"><?= htmlspecialchars($data['gioitinh']) ?></span>
            </div>

            <div class="student-info__field">
                <label class="student-info__label">Ngày sinh:</label>
                <span class="student-info__value"><?= $data['ngaysinh'] ? date('d/m/Y', strtotime($data['ngaysinh'])) : 'Chưa cập nhật' ?></span>
            </div>

            <div class="student-info__field">
                <label class="student-info__label">Số điện thoại:</label>
                <span class="student-info__value"><?= $data['sdt'] ?: 'Chưa cập nhật' ?></span>
            </div>

            <div class="student-info__field">
                <label class="student-info__label">Email:</label>
                <span class="student-info__value"><?= htmlspecialchars($data['email'] ?: 'Chưa cập nhật') ?></span>
            </div>

            <div class="student-info__field">
                <label class="student-info__label">GPA:</label>
                <span class="student-info__value"><?= $data['GPA'] !== null ? number_format($data['GPA'], 2) : 'Chưa cập nhật' ?></span>
            </div>

            <div class="student-info__field">
                <label class="student-info__label">Địa chỉ:</label>
                <span class="student-info__value"><?= htmlspecialchars($data['diachi']) ?></span>
            </div>

            <div class="student-info__footer">
                <a href="index.php" class="student-info__btn student-info__btn--back">Quay lại</a>
                <a href="edit.php?id=<?= $id ?>" class="student-info__btn student-info__btn--edit">Sửa thông tin</a>
            </div>
        </div>
    </div>
</body>
</html>