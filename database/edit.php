<?php
require 'connect.php';

$id = $_GET['id']; // lấy id từ URL
$name = $age = $adress = '';
$nameErr = $ageErr = $adressErr = '';

// Lấy dữ liệu cũ
$sql = "SELECT * FROM student WHERE id=$id";
$result = mysqli_query($conn, $sql);
$student = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate
    if (empty($_POST['nameStudent'])) {
        $nameErr = "Không được để trống trường";
    } else {
        $name = htmlspecialchars($_POST['nameStudent']);
    }

    if (empty($_POST['age'])) {
        $ageErr = "Không được để trống trường";
    } else {
        $age = htmlspecialchars($_POST['age']);
    }

    if (empty($_POST['adress'])) {
        $adressErr = "Không được để trống trường";
    } else {
        $adress = htmlspecialchars($_POST['adress']);
    }

    // Nếu không có lỗi → update
    if ($nameErr == '' && $ageErr == '' && $adressErr == '') {

        $sql = "UPDATE student 
                SET name='$name', age='$age', adress='$adress'
                WHERE id=$id";

        if (mysqli_query($conn, $sql)) {
            header('Location: List.php');
        } else {
            echo 'Cập nhật thất bại: ' . mysqli_error($conn);
        }

        mysqli_close($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Sửa thông tin học sinh</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <form action="" method="post">
        <h2>Sửa thông tin học sinh</h2>
        <input type="text" name="nameStudent" value="<?= $student['name'] ?>"> <br>
        <span style="color: red;"><?= $nameErr ?></span>

        <input type="text" name="age" value="<?= $student['age'] ?>"> <br>
        <span style="color: red;"><?= $ageErr ?></span>

        <select name="adress">
            <option value="">--Chọn Địa chỉ--</option>
            <option <?= $student['adress'] == "Lạng Sơn" ? "selected" : "" ?>>Lạng Sơn</option>
            <option <?= $student['adress'] == "Bắc Ninh" ? "selected" : "" ?>>Bắc Ninh</option>
            <option <?= $student['adress'] == "Hà Nội" ? "selected" : "" ?>>Hà Nội</option>
        </select>
        <span style="color: red;"><?= $adressErr ?></span>

        <button type="submit">Cập nhật</button>
    </form>
</body>

</html>