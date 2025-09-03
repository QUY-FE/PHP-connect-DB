<?php
require 'connect.php';
$sql = "SELECT * FROM student";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <h1>Danh sách học sinh</h1><br>

    <table>
        <thead>
            <tr style="background-color: #63adfc;">
                <td>STT</td>
                <td>Họ và tên</td>
                <td>Tuổi</td>
                <td>Địa chỉ</td>
                <td rowspan="2">Chức năng</td>
            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                            <td> {$row['id']} </td>
                            <td> {$row['name']} </td>
                            <td> {$row['age']} </td>
                            <td> {$row['adress']} </td>
                            <td style='display: flex;gap: 8px;'> 
                                <a class='btn' href='edit.php?id={$row['id']}'>Sửa</a>
                                <a class='btn' style='background-color:red;' href='delete.php?id={$row['id']}'>Xóa</a>
                            </td>
                        </tr>";
                }
            } else {
                echo "<td colspan='5' style='text-align: center;'>Không có học sinh nào ! <a href='index.php'>Thêm học sinh</a></td>
                    ";
            }
            mysqli_close($conn);
            ?>
        </tbody>
    </table><br>
    <a href="index.php" class="btn">Quay lại</a><br>


</body>

</html>