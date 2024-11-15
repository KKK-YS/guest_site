<?php
// 데이터베이스 연결
$host = '192.168.10.5';
$dbname = 'tnhotelDB';
$username = 'hotel';
$password = 'qwer1234';


try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("DB 연결 실패: " . $e->getMessage());
}
?>
