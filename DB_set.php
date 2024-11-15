<?php
// 파일 상단에 추가
error_reporting(E_ALL);
ini_set('display_errors', 1);

// DB 서버 정보 입력
$db_server = "115.31.96.2";     // DB 서버 IP 주소
$db_username = "hotel";         // DB 서버의 MySQL 사용자 이름
$db_password = "1234";  // DB 서버의 MySQL 비밀번호

$conn = new mysqli($db_server, $db_username, $db_password);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// tnhotelDB 생성
$sql = "CREATE DATABASE IF NOT EXISTS tnhotelDB";
if ($conn->query($sql) === TRUE) {
    echo "Database tnhotelDB created successfully<br>";
} else {
    echo "Error creating database tnhotelDB: " . $conn->error . "<br>";
}

// tncomDB 생성
$sql = "CREATE DATABASE IF NOT EXISTS tncomDB";
if ($conn->query($sql) === TRUE) {
    echo "Database tncomDB created successfully<br>";
} else {
    echo "Error creating database tncomDB: " . $conn->error . "<br>";
}

// 연결 종료
$conn->close();
?>
