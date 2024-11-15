<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// 데이터베이스 연결 설정
$servername = "115.31.96.2"; // 서버 주소
$username = "hotel"; // MySQL 사용자 이름
$password = "1234"; // MySQL 비밀번호
$dbname = "tnhotelDB"; // 사용할 데이터베이스 이름

// MySQL 연결
$conn = new mysqli($servername, $username, $password, $dbname);

// 연결 확인
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// memberTB 테이블 생성 SQL 쿼리
$sql = "CREATE TABLE memberTB (
    number INT AUTO_INCREMENT PRIMARY KEY, -- 회원번호 (Primary Key)
    name VARCHAR(100) NOT NULL, -- 이름
    phone VARCHAR(30) NOT NULL, -- 전화번호
    email VARCHAR(255) UNIQUE, -- 이메일
    id VARCHAR(30) UNIQUE, -- ID
    passwd VARCHAR(150) NOT NULL, -- 비밀번호
    regdate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    grade ENUM('일반', 'VIP', 'VVIP') DEFAULT '일반',
    addr VARCHAR(200)
) ENGINE=InnoDB DEFAULT CHARSET=utf8";

// 테이블 생성 실행
if ($conn->query($sql) === TRUE) {
    echo "Table memberTB created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

// 연결 종료
$conn->close();
?>
