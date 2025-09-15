<?php
require_once 'connect.php';

try {
    $limit = 5;
    $page = isset($_GET['page']) && is_numeric($_GET['page'])  ? (int)$_GET['page'] : 1;

    $page = max(1, $page);
    $offset = ($page - 1) * $limit;

    $cntSQL = "SELECT COUNT(*) FROM users";
    $params = [];

    if (!empty($_GET['keyword'])) {
        $keyword = '%' . $_GET['keyword'] . '%';
        $cntSQL .= ' WHERE name LIKE :keyword';
        $params['keyword'] = $keyword;
    }
    $tmp = $pdo->prepare($cntSQL);
    $tmp->execute($params);
    $total_records = (int) $tmp->fetchColumn();
    $total_pages = $total_records > 0 ? ceil($total_records / $limit) : 1;

    $sql = "SELECT * FROM users";
    if (!empty($_GET['keyword'])) {
        $sql .= " WHERE name LIKE :keyword";
    }
    $sql .= " LIMIT :limit OFFSET :offset";
    $tmp = $pdo->prepare($sql);

        if (!empty($_GET['keyword'])) {
            $tmp->bindValue(':keyword', $keyword, PDO::PARAM_STR);
        }
        $tmp->bindValue(':limit', $limit, PDO::PARAM_INT);
        $tmp->bindValue(':offset', $offset, PDO::PARAM_INT);
        $tmp->execute();
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
                foreach ($datas as $key => $data)
                    echo
                    "<tr>
            <td> {$data['id']} </td>
            <td> {$data['name']}</td>
            <td> {$data['class_name']}</td>
            <td> {$data['address']}</td>
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
    <div style="margin-top:20px;">
        <?php if ($total_pages > 1): ?>
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="?page=<?= $i ?>&keyword=<?= isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : '' ?>"
                    style="margin:0 5px; <?= $i == $page ? 'font-weight:bold; color:red;' : '' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>
        <?php endif; ?>
    </div>



</body>

</html>