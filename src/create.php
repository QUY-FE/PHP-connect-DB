<?php
require_once 'connect.php';

$ma_sv = $chuyen_nganh = $email = $sdt = $lop = $gioi_tinh = $ngay_sinh = $GPA = $name = $address = '';
$ma_svError = $chuyen_nganhError = $emailError = $sdtError = $lopError = $gioi_tinhError = $ngay_sinhError = $GPAError = $nameError = $addressError = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // sanitize helper
    $post = function ($k) {
        return isset($_POST[$k]) ? trim($_POST[$k]) : '';
    };

    // ma_sv
    if (empty($post('ma_sv'))) {
        $ma_svError = 'Không để trống mã sinh viên';
    } else {
        $ma_sv = htmlspecialchars($post('ma_sv'));
    }

    // name
    if (empty($post('name'))) {
        $nameError = 'Không để trống cột tên';
    } elseif (mb_strlen($post('name')) > 50) {
        $nameError = 'Tên không được quá 50 ký tự';
    } elseif (!preg_match("/^[\p{L}\s\-']+$/u", $post('name'))) {
        $nameError = 'Tên chỉ chứa chữ cái, khoảng trắng, dấu - và dấu \'.';
    } else {
        $name = htmlspecialchars($post('name'));
    }

    // class_name (lop)
    if (empty($post('class_name'))) {
        $lopError = 'Không để trống lớp';
    } else {
        $lop = htmlspecialchars($post('class_name'));
    }

    // chuyen_nganh
    if (empty($post('chuyen_nganh'))) {
        $chuyen_nganhError = 'Không để trống chuyên ngành';
    } else {
        $chuyen_nganh = htmlspecialchars($post('chuyen_nganh'));
    }

    // gioi_tinh (validate allowed values)
    $allowed_gender = ['Nam', 'Nữ', 'Khác'];
    if (empty($post('gioi_tinh'))) {
        $gioi_tinhError = 'Không để trống giới tính';
    } elseif (!in_array($post('gioi_tinh'), $allowed_gender, true)) {
        $gioi_tinhError = 'Giới tính không hợp lệ';
    } else {
        $gioi_tinh = htmlspecialchars($post('gioi_tinh'));
    }

    // ngay_sinh (optional, validate Y-m-d)
    if (!empty($post('ngay_sinh'))) {
        $d = DateTime::createFromFormat('Y-m-d', $post('ngay_sinh'));
        if (!($d && $d->format('Y-m-d') === $post('ngay_sinh'))) {
            $ngay_sinhError = 'Ngày sinh phải theo định dạng YYYY-MM-DD';
        } else {
            $ngay_sinh = $post('ngay_sinh');
        }
    }

    // sdt
    if (!empty($post('sdt'))) {
        $raw = preg_replace('/\D+/', '', $post('sdt'));
        if (strlen($raw) < 7 || strlen($raw) > 15) {
            $sdtError = 'SĐT không hợp lệ';
        } else {
            $sdt = $raw;
        }
    }

    // email
    if (!empty($post('email'))) {
        if (!filter_var($post('email'), FILTER_VALIDATE_EMAIL)) {
            $emailError = 'Email không hợp lệ';
        } else {
            $email = htmlspecialchars($post('email'));
        }
    }

    // GPA (optional, numeric 0-10 or 0-4). adjust as needed
    if ($post('GPA') !== '') {
        if (!is_numeric($post('GPA'))) {
            $GPAError = 'GPA phải là số';
        } else {
            $gpaVal = (float)$post('GPA');
            if ($gpaVal < 0 || $gpaVal > 4) {
                $GPAError = 'GPA phải trong khoảng 0 - 4';
            } else {
                $GPA = $gpaVal;
            }
        }
    }

    // address (select)
    $validAdress = ["Lạng sơn", "Hà Nội", "Bắc Ninh", "Phú Thọ", "Quảng Ninh", "Hải Phòng", "Cao Bằng", "Điện Biên Phủ", "Hà Giang"];
    if (empty($post('address'))) {
        $addressError = 'Không để trống cột địa chỉ';
    } elseif (!in_array($post('address'), $validAdress, true)) {
        $addressError = 'Địa chỉ không hợp lệ';
    } else {
        $address = htmlspecialchars($post('address'));
    }

    // Nếu không có lỗi thì insert
    $hasError = $ma_svError || $nameError || $lopError || $chuyen_nganhError || $gioi_tinhError || $ngay_sinhError || $sdtError || $emailError || $GPAError || $addressError;

    if (!$hasError) {
        try {
            $sql = "INSERT INTO sinhvien (ma_sv, hoten, lop, chuyen_nganh, gioitinh, ngaysinh, sdt, email, GPA, diachi)
                    VALUES (:ma_sv, :hoten, :lop, :chuyen_nganh, :gioitinh, :ngaysinh, :sdt, :email, :GPA, :diachi)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':ma_sv' => $ma_sv,
                ':hoten' => $name,
                ':lop' => $lop,
                ':chuyen_nganh' => $chuyen_nganh,
                ':gioitinh' => $gioi_tinh,
                ':ngaysinh' => $ngay_sinh,
                ':sdt' => $sdt,
                ':email' => $email,
                ':GPA' => $GPA,
                ':diachi' => $address,
            ]);
            header("Location: index.php");
            exit();
        } catch (PDOException $e) {
            // For debugging: uncomment during development
            // echo 'DB error: ' . $e->getMessage();
            $addressError = 'Lỗi lưu dữ liệu. Kiểm tra cấu trúc bảng hoặc kết nối DB.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm học sinh</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <form action="" method="post" class="form-student">
        <h2 class="form-student__title">Thêm học sinh</h2>

        <div class="form-student__group">
            <label class="form-student__label">Mã sinh viên :</label>
            <input type="text" name="ma_sv" value="<?= htmlspecialchars($ma_sv) ?>" placeholder="Nhập mã sinh viên" class="form-student__input">
            <span class="form-student__error"><?= $ma_svError ?></span>
        </div>

        <div class="form-student__group">
            <label class="form-student__label">Họ tên :</label>
            <input type="text" name="name" value="<?= htmlspecialchars($name) ?>" placeholder="Nhập Họ và tên" class="form-student__input">
            <span class="form-student__error"><?= $nameError ?></span>
        </div>

        <div class="form-student__group">
            <label class="form-student__label">Lớp :</label>
            <input type="text" name="class_name" value="<?= htmlspecialchars($lop) ?>" placeholder="Nhập Lớp" class="form-student__input">
            <span class="form-student__error"><?= $lopError ?></span>
        </div>

        <div class="form-student__group">
            <label class="form-student__label">Chuyên ngành :</label>
            <input type="text" name="chuyen_nganh" value="<?= htmlspecialchars($chuyen_nganh) ?>" placeholder="Nhập chuyên ngành" class="form-student__input">
            <span class="form-student__error"><?= $chuyen_nganhError ?></span>
        </div>

        <div class="form-student__group">
            <label class="form-student__label">Giới tính :</label>
            <select name="gioi_tinh" class="form-student__select">
                <option value="">-- Chọn --</option>
                <option value="Nam" <?= $gioi_tinh == "Nam" ? "selected" : "" ?>>Nam</option>
                <option value="Nữ" <?= $gioi_tinh == "Nữ" ? "selected" : "" ?>>Nữ</option>
                <option value="Khác" <?= $gioi_tinh == "Khác" ? "selected" : "" ?>>Khác</option>
            </select>
            <span class="form-student__error"><?= $gioi_tinhError ?></span>
        </div>

        <div class="form-student__group">
            <label class="form-student__label">Ngày sinh (YYYY-MM-DD) :</label>
            <input type="date" name="ngay_sinh" value="<?= htmlspecialchars($ngay_sinh) ?>" class="form-student__input">
            <span class="form-student__error"><?= $ngay_sinhError ?></span>
        </div>

        <div class="form-student__group">
            <label class="form-student__label">Số điện thoại :</label>
            <input type="text" name="sdt" value="<?= htmlspecialchars($sdt) ?>" placeholder="Nhập SĐT" class="form-student__input">
            <span class="form-student__error"><?= $sdtError ?></span>
        </div>

        <div class="form-student__group">
            <label class="form-student__label">Email :</label>
            <input type="email" name="email" value="<?= htmlspecialchars($email) ?>" placeholder="Nhập email" class="form-student__input">
            <span class="form-student__error"><?= $emailError ?></span>
        </div>

        <div class="form-student__group">
            <label class="form-student__label">Điểm GPA :</label>
            <input type="text" name="GPA" value="<?= htmlspecialchars($GPA) ?>" placeholder="Nhập GPA (0-4)" class="form-student__input">
            <span class="form-student__error"><?= $GPAError ?></span>
        </div>

        <div class="form-student__group">
            <label class="form-student__label">Địa chỉ :</label>
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

        <button type="submit" class="form-student__button">Thêm sinh viên</button>
    </form>

    <a href="index.php" class="form-student__link">Xem danh sách</a>
</body>


</html>