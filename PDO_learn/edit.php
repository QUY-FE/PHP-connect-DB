<?php
require_once 'connect.php';

$name = $age = $address = '';
$nameError = $ageError = $addressError = '';

$id = $_GET['id'];
$sql = "SELECT * FROM student WHERE id=:id";
$tmp = $pdo->prepare($sql);
$tmp->execute(['id' => $id]);
$data = $tmp->fetch(PDO::FETCH_ASSOC);
if (!$data) {
    die("Không tìm thấy học sinh");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Kiểm tra dữ liệu khi submit cột name
    if (empty($_POST['name'])) {
        $nameError = 'Không để trống cột tên';
    } else {
        $name = htmlspecialchars($_POST['name']);
        $nameError = '';
    }
    // Kiểm tra dữ liệu khi submit cột age
    if (empty($_POST['age'])) {
        $ageError = 'Không để trống cột tuổi';
    } else {
        $age = htmlspecialchars((int)$_POST['age']);
        $ageError = '';
    }
    // Kiểm tra dữ liệu khi submit cột address
    if (empty($_POST['adress'])) {
        $addressError = 'Không để trống cột địa chỉ';
    } else {
        $address = htmlspecialchars($_POST['adress']);
        $addressError = '';
    }
    if ($nameError === '' && $ageError === '' && $addressError === '') {
        $data = [
            'id' => $id,
            'name' => $name,
            'age' => $age,
            'adress' => $address,
        ];
        $sql = "UPDATE student SET name = :name, age = :age, adress = :adress WHERE id = :id";
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
    <title>Sửa thông tin học sinh</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <form action="" method="post">
        <h2>Sửa thông tin học sinh</h2>

        Họ tên:
        <input type="text" name="name" value="<?= $data['name'] ?>"> <br>
        <span style="color: red;"><?= $nameError ?></span><br>

        Tuổi:
        <input type="text" name="age" value="<?= $data['age'] ?>"> <br>
        <span style="color: red;"><?= $ageError ?></span><br>

        Địa chỉ:
        <select name="adress">
            <option value="">-- Chọn địa chỉ --</option>
            <option value="Lạng sơn" <?= $data['adress'] == "Lạng sơn" ? "selected" : "" ?>>Lạng sơn</option>
            <option value="Hà Nội" <?= $data['adress'] == "Hà Nội" ? "selected" : "" ?>>Hà Nội</option>
            <option value="Bắc Ninh" <?= $data['adress'] == "Bắc Ninh" ? "selected" : "" ?>>Bắc Ninh</option>
            <option value="Phú Thọ" <?= $data['adress'] == "Phú Thọ" ? "selected" : "" ?>>Phú Thọ</option>
            <option value="Quảng Ninh" <?= $data['adress'] == "Quảng Ninh" ? "selected" : "" ?>>Quảng Ninh</option>
            <option value="Hải Phòng" <?= $data['adress'] == "Hải Phòng" ? "selected" : "" ?>>Hải Phòng</option>
            <option value="Cao Bằng" <?= $data['adress'] == "Cao Bằng" ? "selected" : "" ?>>Cao Bằng</option>
            <option value="Điện Biên Phủ" <?= $data['adress'] == "Điện Biên Phủ" ? "selected" : "" ?>>Điện Biên Phủ</option>
            <option value="Hà Giang" <?= $data['adress'] == "Hà Giang" ? "selected" : "" ?>>Hà Giang</option>
        </select>
        <span style="color: red;"><?= $addressError ?></span> <br><br>

        <button type="submit">Sửa</button>
    </form>
    <a href="index.php" class="btn">Danh sách</a>
</body>

</html>