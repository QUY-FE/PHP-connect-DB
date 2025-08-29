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
    <link rel="stylesheet" href="output.css">
</head>

<body>
    <h2>Danh sach hoc sinh</h2><br>
    <table>
        <thead>
            <tr>
                <td>ID</td>
                <td>Name</td>
                <td>Age</td>
                <td>Address</td>
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
                            <td> 
                                <a href='edit.php?id={$row['id']}'>Sửa</a>
                                <a href='delete.php?id={$row['id']}'>Xóa</a>
                            </td>
                        </tr>";
                }
            } else {
                echo "<h2>Khong có dữ liệu</h2>";
            }
            mysqli_close($conn);
            ?>
        </tbody>
    </table><br>
    <a href="index.php">Quay lại Trang chủ</a>

</body>

</html>