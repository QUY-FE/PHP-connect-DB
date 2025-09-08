<?php
require_once 'connect.php';

try {
    $sql = "SELECT * FROM student ";
    $params = [];
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        if (!empty($_GET['keyword'])) {
            $keyword = '%' . $_GET['keyword'] . '%';
            $sql .= ' WHERE name LIKE :keyword';
            $params['keyword'] = $keyword;
        }
    }
    $tmp = $pdo->prepare($sql);
    $tmp->execute($params);
    $datas = $tmp->fetchAll(PDO::FETCH_ASSOC);
} catch (\Throwable $e) {
    echo 'Lỗi,Không thể truy vấn dữ liệu' . $e->getMessage();
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách học sinh</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <form action="" method="get">
        <input type="text" name="keyword" placeholder="Tìm Kiếm . . . ." value="<?= isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : ''; ?>">
        <button type="submit">Tìm Kiếm</button>
    </form>
    <h1>Danh sách học sinh</h1><br>

    <table>
        <thead>
            <tr style="background-color: #63adfc;">
                <td>STT</td>
                <td>Họ và tên</td>
                <td>Tuổi</td>
                <td>Địa chỉ</td>
                <td>Chức năng</td>
            </tr>
        </thead>
        <tbody>
            <?php
            if (count($datas) > 0) {
                foreach ($datas as $data)
                    echo
                    "<tr>
            <td> {$data['id']} </td>
            <td> {$data['name']}</td>
            <td> {$data['age']}</td>
            <td> {$data['adress']}</td>
            <td style='display: flex; gap:12px;'>
            
            <a href='edit.php?id={$data['id']}' class='btn'>Sửa</a> 
            <a href='delete.php?id={$data['id']}' class='btn' '>Xóa</a>
            </td>                           
            </tr>";
                echo
                "<tr >
                <td colspan='5'>
                    <a href='create.php' class='btn'>Thêm học sinh</a><br>
                </td>
            </tr>";
            } else {
                echo
                "<tr>
                    <td colspan='5'> <h3>Không có học sinh nào :( <a href='create.php' class='btn'>Thêm học sinh</a><br></h3> </td>
                </tr>";
            }
            ?>
        </tbody>
    </table><br>



</body>

</html>