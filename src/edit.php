<?php
require_once 'connect.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    die('ID không hợp lệ');
}

// fetch existing
$sql = "SELECT * FROM sinhvien WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $id]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$data) {
    die('Không tìm thấy học sinh');
}

/* init */
$ma_sv = $data['ma_sv'] ?? '';
$name = $data['hoten'] ?? ''; // Sửa thành lấy từ cột hoten
$class_name = $data['lop'] ?? $data['class_name'] ?? ''; // Giữ nguyên cho lớp
$chuyen_nganh = $data['chuyen_nganh'] ?? '';
$gioi_tinh = $data['gioitinh'] ?? $data['gioi_tinh'] ?? '';
$ngay_sinh = $data['ngaysinh'] ?? $data['ngay_sinh'] ?? '';
$sdt = $data['sdt'] ?? '';
$email = $data['email'] ?? '';
$GPA = $data['GPA'] ?? '';
$address = $data['diachi'] ?? $data['address'] ?? '';

$ma_svError = $nameError = $class_nameError = $chuyen_nganhError = $gioi_tinhError = $ngay_sinhError = $sdtError = $emailError = $GPAError = $addressError = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post = function($k){ return isset($_POST[$k]) ? trim($_POST[$k]) : ''; };

    // ma_sv
    if (empty($post('ma_sv'))) {
        $ma_svError = 'Không để trống mã sinh viên';
    } else {
        $ma_sv = htmlspecialchars($post('ma_sv'));
    }

    // name
    if (empty($post('name'))) {
        $nameError = 'Không để trống tên';
    } elseif (mb_strlen($post('name')) > 50) {
        $nameError = 'Tên không được quá 50 ký tự';
    } else {
        $name = htmlspecialchars($post('name'));
    }

    // class_name
    if (empty($post('class_name'))) {
        $class_nameError = 'Không để trống lớp';
    } else {
        $class_name = htmlspecialchars($post('class_name'));
    }

    // chuyen_nganh
    if (empty($post('chuyen_nganh'))) {
        $chuyen_nganhError = 'Không để trống chuyên ngành';
    } else {
        $chuyen_nganh = htmlspecialchars($post('chuyen_nganh'));
    }

    // gioi_tinh
    $allowed_gender = ['Nam','Nữ','Khác'];
    if (empty($post('gioi_tinh'))) {
        $gioi_tinhError = 'Không để trống giới tính';
    } elseif (!in_array($post('gioi_tinh'), $allowed_gender, true)) {
        $gioi_tinhError = 'Giới tính không hợp lệ';
    } else {
        $gioi_tinh = htmlspecialchars($post('gioi_tinh'));
    }

    // ngay_sinh
    if (!empty($post('ngay_sinh'))) {
        $d = DateTime::createFromFormat('Y-m-d', $post('ngay_sinh'));
        if (!($d && $d->format('Y-m-d') === $post('ngay_sinh'))) {
            $ngay_sinhError = 'Ngày sinh phải theo định dạng YYYY-MM-DD';
        } else {
            $ngay_sinh = $post('ngay_sinh');
        }
    } else {
        $ngay_sinh = '';
    }

    // sdt
    if (!empty($post('sdt'))) {
        $raw = preg_replace('/\D+/', '', $post('sdt'));
        if (strlen($raw) < 7 || strlen($raw) > 15) {
            $sdtError = 'SĐT không hợp lệ';
        } else {
            $sdt = $raw;
        }
    } else {
        $sdt = '';
    }

    // email
    if (!empty($post('email'))) {
        if (!filter_var($post('email'), FILTER_VALIDATE_EMAIL)) {
            $emailError = 'Email không hợp lệ';
        } else {
            $email = htmlspecialchars($post('email'));
        }
    } else {
        $email = '';
    }

    // GPA
    if ($post('GPA') !== '') {
        if (!is_numeric($post('GPA'))) {
            $GPAError = 'GPA phải là số';
        } else {
            $g = (float)$post('GPA');
            if ($g < 0 || $g > 10) {
                $GPAError = 'GPA phải trong khoảng 0 - 10';
            } else {
                $GPA = $g;
            }
        }
    } else {
        $GPA = '';
    }

    // address
    $validAdress = ["Lạng sơn", "Hà Nội", "Bắc Ninh", "Phú Thọ", "Quảng Ninh", "Hải Phòng", "Cao Bằng", "Điện Biên Phủ", "Hà Giang"];
    if (empty($post('address'))) {
        $addressError = 'Không để trống địa chỉ';
    } elseif (!in_array($post('address'), $validAdress, true)) {
        $addressError = 'Địa chỉ không hợp lệ';
    } else {
        $address = htmlspecialchars($post('address'));
    }

    $hasError = $ma_svError || $nameError || $class_nameError || $chuyen_nganhError || $gioi_tinhError || $ngay_sinhError || $sdtError || $emailError || $GPAError || $addressError;

    if (!$hasError) {
        $sql = "UPDATE sinhvien SET ma_sv=:ma_sv, hoten=:hoten, lop=:lop, chuyen_nganh=:chuyen_nganh, gioitinh=:gioitinh, ngaysinh=:ngaysinh, sdt=:sdt, email=:email, GPA=:GPA, diachi=:diachi WHERE id=:id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':ma_sv' => $ma_sv,
            ':hoten' => $name,
            ':lop' => $class_name,
            ':chuyen_nganh' => $chuyen_nganh,
            ':gioitinh' => $gioi_tinh,
            ':ngaysinh' => $ngay_sinh,
            ':sdt' => $sdt,
            ':email' => $email,
            ':GPA' => $GPA,
            ':diachi' => $address,
            ':id' => $id,
        ]);
        header('Location: index.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Sửa sinh viên</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <form action="" method="post" class="form-student">
        <h2 class="form-student__title">Sửa thông tin sinh viên</h2>

        <div class="form-student__group">
            <label class="form-student__label">Mã sinh viên</label>
            <input class="form-student__input" name="ma_sv" type="text" value="<?= htmlspecialchars($ma_sv) ?>">
            <span class="form-student__error"><?= $ma_svError ?></span>
        </div>

        <div class="form-student__group">
            <label class="form-student__label">Họ tên</label>
            <input class="form-student__input" name="name" type="text" value="<?= htmlspecialchars($name) ?>">
            <span class="form-student__error"><?= $nameError ?></span>
        </div>

        <div class="form-student__group">
            <label class="form-student__label">Lớp</label>
            <input class="form-student__input" name="class_name" type="text" value="<?= htmlspecialchars($class_name) ?>">
            <span class="form-student__error"><?= $class_nameError ?></span>
        </div>

        <div class="form-student__group">
            <label class="form-student__label">Chuyên ngành</label>
            <input class="form-student__input" name="chuyen_nganh" type="text" value="<?= htmlspecialchars($chuyen_nganh) ?>">
            <span class="form-student__error"><?= $chuyen_nganhError ?></span>
        </div>

        <div class="form-student__group">
            <label class="form-student__label">Giới tính</label>
            <select name="gioi_tinh" class="form-student__select">
                <option value="">-- Chọn --</option>
                <option value="Nam" <?= $gioi_tinh == "Nam" ? "selected" : "" ?>>Nam</option>
                <option value="Nữ" <?= $gioi_tinh == "Nữ" ? "selected" : "" ?>>Nữ</option>
                <option value="Khác" <?= $gioi_tinh == "Khác" ? "selected" : "" ?>>Khác</option>
            </select>
            <span class="form-student__error"><?= $gioi_tinhError ?></span>
        </div>

        <div class="form-student__group">
            <label class="form-student__label">Ngày sinh</label>
            <input class="form-student__input" name="ngay_sinh" type="date" value="<?= htmlspecialchars($ngay_sinh) ?>">
            <span class="form-student__error"><?= $ngay_sinhError ?></span>
        </div>

        <div class="form-student__group">
            <label class="form-student__label">Số điện thoại</label>
            <input class="form-student__input" name="sdt" type="text" value="<?= htmlspecialchars($sdt) ?>">
            <span class="form-student__error"><?= $sdtError ?></span>
        </div>

        <div class="form-student__group">
            <label class="form-student__label">Email</label>
            <input class="form-student__input" name="email" type="email" value="<?= htmlspecialchars($email) ?>">
            <span class="form-student__error"><?= $emailError ?></span>
        </div>

        <div class="form-student__group">
            <label class="form-student__label">GPA</label>
            <input class="form-student__input" name="GPA" type="text" value="<?= htmlspecialchars($GPA) ?>">
            <span class="form-student__error"><?= $GPAError ?></span>
        </div>

        <div class="form-student__group">
            <label class="form-student__label">Địa chỉ</label>
            <select name="address" class="form-student__select">
                <option value="">-- Chọn địa chỉ --</option>
                <option value="Lạng sơn" <?= $address == "Lạng sơn" ? "selected" : "" ?>>Lạng sơn</option>
                <option value="Hà Nội" <?= $address == "Hà Nội" ? "selected" : "" ?>>Hà Nội</option>
                <option value="Bắc Ninh" <?= $address == "Bắc Ninh" ? "selected" : "" ?>>Bắc Ninh</option>
                <option value="Phú Thọ" <?= $address == "Phú Thọ" ? "selected" : "" ?>>Phú Thọ</option>
                <option value="Quảng Ninh" <?= $address == "Quảng Ninh" ? "selected" : "" ?>>Quảng Ninh</option>
                <option value="Hải Phòng" <?= $address == "Hải Phòng" ? "selected" : "" ?>>Hải Phòng</option>
                <option value="Cao Bằng" <?= $address == "Cao Bằng" ? "selected" : "" ?>>Cao Bằng</option>
                <option value="Điện Biên Phủ" <?= $address == "Điện Biên Phủ" ? "selected" : "" ?>>Điện Biên Phủ</option>
                <option value="Hà Giang" <?= $address == "Hà Giang" ? "selected" : "" ?>>Hà Giang</option>
            </select>
            <span class="form-student__error"><?= $addressError ?></span>
        </div>

        <button type="submit" class="form-student__button">Lưu thay đổi</button>
    </form>

    <a href="index.php" class="form-student__link">Quay về danh sách</a>
</body>
</html>