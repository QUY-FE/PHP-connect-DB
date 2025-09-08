<?php
require_once 'connect.php';
$id = $_GET['id'];
try {
    $sql = "DELETE FROM student WHERE id=:id";
    $tmp = $pdo->prepare($sql);
    $tmp->execute(['id' => $id]);
    header('Location: index.php');
} catch (\Throwable $e) {
    echo 'Lỗi không thể xóa' . $e->getMessage();
}
