<?php
require 'connect.php';

$id = $_GET['id']; // lấy id từ URL


// Lấy dữ liệu cũ
// $sql = "SELECT * FROM student WHERE id=$id";
// $result = mysqli_query($conn, $sql);
// $student = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Nếu không có lỗi → delete
    if ($nameErr == '' && $ageErr == '' && $adressErr == '') {

        $sql = "DELETE FROM student WHERE id=$id";

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
    <title>Sửa Học Sinh</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <form action="" method="post">
        <h2>Thông báo</h2>
        <p>Bạn có chắc muốn xóa học sinh này</p>

        <button type="submit">Xóa</button>
    </form>
    <br>
    <a class="btn" href="List.php">Quay lại</a>
</body>

</html>