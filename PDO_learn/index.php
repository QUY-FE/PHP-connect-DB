<?php
require_once 'connect.php';

try {
    $limit = 5;
    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
    $page = max(1, $page);
    $offset = ($page - 1) * $limit;

    // Đếm tổng số bản ghi
    $cntSQL = "SELECT COUNT(*) FROM sinhvien";
    $stmt = $pdo->query($cntSQL);
    $total_records = (int)$stmt->fetchColumn();
    $total_pages = $total_records > 0 ? ceil($total_records / $limit) : 1;

    // Lấy danh sách sinh viên theo phân trang
    $sql = "SELECT * FROM sinhvien LIMIT :limit OFFSET :offset";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $datas = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (\Throwable $e) {
    echo 'Lỗi, Không thể truy vấn dữ liệu: ' . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách học sinh</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <h1 class="student-list__title">Danh sách học sinh</h1>

    <table class="student-list__table">
        <thead class="student-list__thead">
            <tr class="student-list__row student-list__row--header">
                <th class="student-list__cell">Mã SV</th>
                <th class="student-list__cell">Họ và tên</th>
                <th class="student-list__cell">Lớp</th>
                <th class="student-list__cell">Địa chỉ</th>
                <th class="student-list__cell">Chức năng</th>
            </tr>
        </thead>
        <tbody class="student-list__tbody">
            <?php if (!empty($datas)): ?>
                <?php foreach ($datas as $data): ?>
                    <tr class="student-list__row">
                        <td class="student-list__cell"><?= htmlspecialchars($data['ma_sv']) ?></td>
                        <td class="student-list__cell"><?= htmlspecialchars($data['hoten']) ?></td>
                        <td class="student-list__cell"><?= htmlspecialchars($data['lop']) ?></td>
                        <td class="student-list__cell"><?= htmlspecialchars($data['diachi']) ?></td>
                        <td class="student-list__cell student-list__cell--actions">
                            <a href="info.php?id=<?= $data['id'] ?>" class="student-list__btn student-list__btn--info">Xem thông tin</a>
                            <a href="edit.php?id=<?= $data['id'] ?>" class="student-list__btn">Sửa</a>
                            <a href="delete.php?id=<?= $data['id'] ?>" class="student-list__btn student-list__btn--danger">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>

                <tr class="student-list__row">
                    <td colspan="5" class="student-list__cell student-list__cell--center">
                        <a href="create.php" class="student-list__btn student-list__btn--primary">Thêm học sinh</a>
                    </td>
                </tr>
            <?php else: ?>
                <tr class="student-list__row">
                    <td colspan="5" class="student-list__cell student-list__cell--center">
                        <h3>Không có học sinh nào 
                            <a href="create.php" class="student-list__btn student-list__btn--primary">Thêm học sinh</a>
                        </h3>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="student-list__pagination">
        <?php if ($total_pages > 1): ?>
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="?page=<?= $i ?>" 
                   class="student-list__pagination-link <?= $i == $page ? 'student-list__pagination-link--active' : '' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>
        <?php endif; ?>
    </div>

</body>


</html>
