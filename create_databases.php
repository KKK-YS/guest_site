<?php
$servername = "115.31.96.2"; // 데이터베이스 서버 이름
$username = "root"; // 데이터베이스 사용자 이름
$password = "P@ssw0rd"; // 데이터베이스 비밀번호

// 데이터베이스 연결
$conn = new mysqli($servername, $username, $password);

// 연결 확인
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// tnhotelDB 데이터베이스 생성
$sql = "CREATE DATABASE tnhotelDB";
if ($conn->query($sql) === TRUE) {
    echo "Database tnhotelDB created successfully<br>";
} else {
    echo "Error creating database tnhotelDB: " . $conn->error . "<br>";
}

// tncomDB 데이터베이스 생성
$sql = "CREATE DATABASE tncomDB";
if ($conn->query($sql) === TRUE) {
    echo "Database tncomDB created successfully<br>";
} else {
    echo "Error creating database tncomDB: " . $conn->error . "<br>";
}

// tnhotelDB 테이블 생성
$conn->select_db("tnhotelDB");

$sql = "CREATE TABLE memberTB (
    member_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    phone VARCHAR(20),
    email VARCHAR(100),
    username VARCHAR(50) UNIQUE,
    password VARCHAR(255),
    join_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "Table memberTB created successfully in tnhotelDB<br>";
} else {
    echo "Error creating table memberTB: " . $conn->error . "<br>";
}

$sql = "CREATE TABLE reservTB (
    reservation_id INT AUTO_INCREMENT PRIMARY KEY,
    member_id INT,
    customer_name VARCHAR(100),
    check_in_date DATE,
    check_out_date DATE,
    room_id INT,
    FOREIGN KEY (member_id) REFERENCES memberTB(member_id)
)";

if ($conn->query($sql) === TRUE) {
    echo "Table reservTB created successfully in tnhotelDB<br>";
} else {
    echo "Error creating table reservTB: " . $conn->error . "<br>";
}

$sql = "CREATE TABLE noticesTB (
    notice_id INT AUTO_INCREMENT PRIMARY KEY,
    notice_content TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "Table noticesTB created successfully in tnhotelDB<br>";
} else {
    echo "Error creating table noticesTB: " . $conn->error . "<br>";
}

// tncomDB 테이블 생성
$conn->select_db("tncomDB");

$sql = "CREATE TABLE memberTB (
    member_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    phone VARCHAR(20),
    email VARCHAR(100),
    username VARCHAR(50) UNIQUE,
    password VARCHAR(255),
    join_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "Table memberTB created successfully in tncomDB<br>";
} else {
    echo "Error creating table memberTB: " . $conn->error . "<br>";
}

$sql = "CREATE TABLE familyTB (
    employee_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    username VARCHAR(50) UNIQUE,
    password VARCHAR(255),
    department VARCHAR(100),
    phone VARCHAR(20),
    hire_date DATE
)";

if ($conn->query($sql) === TRUE) {
    echo "Table familyTB created successfully in tncomDB<br>";
} else {
    echo "Error creating table familyTB: " . $conn->error . "<br>";
}

$sql = "CREATE TABLE roomTB (
    room_id INT AUTO_INCREMENT PRIMARY KEY,
    room_status ENUM('Available', 'Occupied', 'Cleaning'),
    room_type VARCHAR(100),
    current_rate DECIMAL(10, 2)
)";

if ($conn->query($sql) === TRUE) {
    echo "Table roomTB created successfully in tncomDB<br>";
} else {
    echo "Error creating table roomTB: " . $conn->error . "<br>";
}

$sql = "CREATE TABLE reservTB (
    reservation_id INT AUTO_INCREMENT PRIMARY KEY,
    member_id INT,
    customer_name VARCHAR(100),
    check_in_date DATE,
    check_out_date DATE,
    room_id INT,
    FOREIGN KEY (member_id) REFERENCES memberTB(member_id)
)";

if ($conn->query($sql) === TRUE) {
    echo "Table reservTB created successfully in tncomDB<br>";
} else {
    echo "Error creating table reservTB: " . $conn->error . "<br>";
}

// 트리거 생성: 고객 가입 시 tncomDB에 데이터 추가
$sql = "
CREATE TRIGGER after_member_insert
AFTER INSERT ON tnhotelDB.memberTB
FOR EACH ROW
BEGIN
    INSERT INTO tncomDB.memberTB (name, phone, email, username, password, join_date)
    VALUES (NEW.name, NEW.phone, NEW.email, NEW.username, NEW.password, NEW.join_date);
END;
";

if ($conn->query($sql) === TRUE) {
    echo "Trigger after_member_insert created successfully<br>";
} else {
    echo "Error creating trigger after_member_insert: " . $conn->error . "<br>";
}

// 트리거 생성: 고객 예약 시 tncomDB에 데이터 추가
$sql = "
CREATE TRIGGER after_reserv_insert
AFTER INSERT ON tnhotelDB.reservTB
FOR EACH ROW
BEGIN
    INSERT INTO tncomDB.reservTB (member_id, customer_name, check_in_date, check_out_date, room_id)
    VALUES (NEW.member_id, NEW.customer_name, NEW.check_in_date, NEW.check_out_date, NEW.room_id);
END;
";

if ($conn->query($sql) === TRUE) {
    echo "Trigger after_reserv_insert created successfully<br>";
} else {
    echo "Error creating trigger after_reserv_insert: " . $conn->error . "<br>";
}

// 연결 종료
$conn->close();
?>
