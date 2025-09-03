<?php
require 'connect.php';

$name = $age = $address = '';
$nameErr = $ageErr = $addressErr = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['nameStudent'])) {
        $nameErr = "Không được để trống trường";
    } else {
        $name = htmlspecialchars($_POST['nameStudent']);
        $nameErr = '';
    }
    if (empty($_POST['age'])) {
        $ageErr = "Không được để trống trường";
    } else {
        $age = htmlspecialchars($_POST['age']);
        $ageErr = '';
    }
    if (empty($_POST['address'])) {
        $addressErr = "Không được để trống trường";
    } else {
        $address = htmlspecialchars($_POST['address']);
        $addressErr = '';
    }


    if ($nameErr == '' && $ageErr == '' && $addressErr == '') {
        $sql = "INSERT INTO student (name,age,adress) 
                    VALUES ('$name','$age','$address');";

        if (mysqli_query($conn, $sql)) {
            header('Location: List.php');
        } else {
            echo 'Không The them' . mysqli_error($conn);
        }
        mysqli_close($conn);
    }
}



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Học sinh với form vào mySQL</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <form action="" method="post">
        <h2>Nhập thông tin học sinh</h2>
        <input type="text" placeholder="Nhập họ và tên" name="nameStudent"> <br>
        <span style="color: red;"><?= $nameErr ?> </span>
        <input type="text" placeholder="Nhập Tuổi" name="age"> <br>
        <span style="color: red;"><?= $ageErr ?> </span>
        <select name="address">
            <option value="">--Chọn Địa chỉ--</option>
            <option value="Lạng Sơn">Lạng Sơn</option>
            <option value="Bắc Ninh">Bắc Ninh</option>
            <option value="Hà Nội">Hà Nội</option>
        </select>
        <span style="color: red;"><?= $addressErr ?> </span>
        <button type="submit">Thêm</button>
    </form>
    <br>
    <a class="btn" href="List.php">Xem danh sách</a> <br>

</body>

</html>