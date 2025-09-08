<?php
$host = 'localhost';
$userName = 'root';
$password = '';
$dbName = 'test';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbName;charset=utf8", $userName, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo '<h4 style="color: green;">o</h4>';
} catch (\Throwable $th) {
    echo '<h4 style="color: red;">x</h4>' . $th->getMessage();
}
