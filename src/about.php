<?php require_once 'connect.php'; ?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giới thiệu - Hệ thống Quản lý Sinh viên</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="about">
        <div class="about__container">
            <h1 class="about__title">Hệ thống Quản lý Sinh viên</h1>

            <div class="about__content">
                <section class="about__section">
                    <h2 class="about__subtitle">Giới thiệu</h2>
                    <p>Hệ thống Quản lý Sinh viên là một giải pháp toàn diện giúp quản lý thông tin sinh viên một cách hiệu quả. Được phát triển bằng PHP và MySQL, hệ thống cung cấp giao diện thân thiện và dễ sử dụng.</p>
                </section>

                <section class="about__section">
                    <h2 class="about__subtitle">Tính năng chính</h2>
                    <ul class="about__features">
                        <li>Quản lý thông tin cơ bản của sinh viên</li>
                        <li>Tìm kiếm và lọc sinh viên theo nhiều tiêu chí</li>
                        <li>Thêm, sửa, xóa thông tin sinh viên</li>
                        <li>Xem chi tiết thông tin từng sinh viên</li>
                        <li>Phân trang danh sách sinh viên</li>
                        <li>Validation dữ liệu chặt chẽ</li>
                    </ul>
                </section>

                <section class="about__section">
                    <h2 class="about__subtitle">Thông tin kỹ thuật</h2>
                    <ul class="about__tech">
                        <li><strong>Backend:</strong> PHP, PDO</li>
                        <li><strong>Database:</strong> MySQL</li>
                        <li><strong>Frontend:</strong> HTML5, CSS3</li>
                        <li><strong>Bảo mật:</strong> XSS Prevention, SQL Injection Protection</li>
                    </ul>
                </section>

                <section class="about__section">
                    <h2 class="about__subtitle">Hướng dẫn sử dụng</h2>
                    <div class="about__guide">
                        <p><strong>1. Xem danh sách sinh viên:</strong> Truy cập trang chủ</p>
                        <p><strong>2. Thêm sinh viên mới:</strong> Click nút "Thêm học sinh"</p>
                        <p><strong>3. Xem chi tiết:</strong> Click nút "Xem thông tin" bên cạnh mỗi sinh viên</p>
                        <p><strong>4. Chỉnh sửa:</strong> Sử dụng nút "Sửa" để cập nhật thông tin</p>
                    </div>
                </section>
            </div>

            <div class="about__footer">
                <a href="index.php" class="about__btn">Quay về trang chủ</a>
                <p class="about__copyright">© <?= date('Y') ?> QUY-FE. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>

</html>