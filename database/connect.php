<?php

$host = 'localhost';
$username = 'root';
$password = '';
$db_name = 'test';

$conn = mysqli_connect($host, $username, $password, $db_name);

if (!$conn) {
    die("ket noi that bai" . mysqli_connect_errno());
}
