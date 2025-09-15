<?php
require_once 'connect.php';
$name = $class_name = $address = '';
$nameError = $class_nameError = $addressError = '';
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
    if (empty($_POST['class_name'])) {
        $class_nameError = 'Không để trống cột tuổi';
    } else {
        $class_name = $_POST['class_name'];
        $class_nameError = '';
    }
    // Kiểm tra dữ liệu khi submit cột address
    $validAdress = ["Lạng sơn", "Hà Nội", "Bắc Ninh", "Phú Thọ", "Quảng Ninh", "Hải Phòng", "Cao Bằng", "Điện Biên Phủ", "Hà Giang"];

    if (empty($_POST['address'])) {
        $addressError = 'Không để trống cột địa chỉ';
    } elseif (!in_array($_POST['address'], $validAdress)) {
        $addressError = 'Địa chỉ không hợp lệ';
    } else {
        $address = htmlspecialchars($_POST['address']);
        $addressError = '';
    }


    // Nếu không có lỗi Thêm vào db
    if ($nameError === '' && $class_nameError === '' && $addressError === '') {
        $data = [
            ':name' => $name,
            ':class_name' => $class_name,
            ':address' => $address,
        ];
        $sql = "INSERT INTO users (name, class_name,address)
                 VALUES (:name,:class_name,:address)";
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

        Lớp
        <input type="text" name="class_name" value="<?= $class_name ?>" placeholder="Nhập Lớp"> <br>
        <span style="color: red;"><?= $class_nameError ?></span><br>

        Địa chỉ:
        <select name="address">
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