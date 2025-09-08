<?php
require_once 'connect.php';
$name = $age = $address = '';
$nameError = $ageError = $addressError = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Kiểm tra dữ liệu khi submit cột name
    if (empty($_POST['name'])) {
        $nameError = 'Không để trống cột tên';
    } elseif (strlen($_POST['name']) > 50) {
        $nameError = 'Tên không được quá 50 ký tự';

        $name = '';
    } elseif (!preg_match("/^[\p{L}\s]+$/u", $_POST['name'])) {
        $nameError = 'Tên chỉ chứa chữ cái và khoảng trắng';
    } else {
        $name = htmlspecialchars($_POST['name']);
        $nameError = '';
    }
    // Kiểm tra dữ liệu khi submit cột age
    if (empty($_POST['age'])) {
        $ageError = 'Không để trống cột tuổi';
    } elseif (!is_numeric($_POST['age'])) {
        $ageError = 'Tuổi phải là số';
    } elseif ($_POST['age'] < 5 || $_POST['age'] > 100) {
        $ageError = 'Tuổi phải từ 5 đến 100';
    } else {
        $age = (int) $_POST['age'];
        $ageError = '';
    }
    // Kiểm tra dữ liệu khi submit cột address
    $validAdress = ["Lạng sơn", "Hà Nội", "Bắc Ninh", "Phú Thọ", "Quảng Ninh", "Hải Phòng", "Cao Bằng", "Điện Biên Phủ", "Hà Giang"];

    if (empty($_POST['adress'])) {
        $addressError = 'Không để trống cột địa chỉ';
    } elseif (!in_array($_POST['adress'], $validAdress)) {
        $addressError = 'Địa chỉ không hợp lệ';
    } else {
        $address = htmlspecialchars($_POST['adress']);
        $addressError = '';
    }


    // Nếu không có lỗi Thêm vào db
    if ($nameError === '' && $ageError === '' && $addressError === '') {
        $data = [
            ':name' => $name,
            ':age' => $age,
            ':adress' => $address,
        ];
        $sql = "INSERT INTO student (name, age,adress)
                 VALUES (:name,:age,:adress)";
        $tmp = $pdo->prepare($sql);
        $tmp->execute($data);
        header("Location: index.php");
        exit();
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm học sinh</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <form action="" method="post">
        <h2>Thêm học sinh</h2>

        Họ tên:
        <input type="text" name="name" value="<?= $name ?>" placeholder="Nhập Họ và tên"> <br>
        <span style="color: red;"><?= $nameError ?></span><br>

        Tuổi:
        <input type="text" name="age" value="<?= $age ?>" placeholder="Nhập tuổi"> <br>
        <span style="color: red;"><?= $ageError ?></span><br>

        Địa chỉ:
        <select name="adress">
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
        <span style="color: red;"><?= $addressError ?></span> <br><br>

        <button type="submit">Thêm</button>
    </form>
    <a href="index.php" class="btn">xem danh sách</a>
</body>

</html>