<?php
// 에러 메시지 출력을 활성화
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 데이터베이스 연결 설정
$host = '115.31.96.2';
$dbname = 'tnhotelDB';
$user = 'hotel'; // 데이터베이스 사용자명
$pass = '1234'; // 데이터베이스 비밀번호

try {
    // 데이터베이스 연결
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // memberTB 테이블 생성
    $sql1 = "
        CREATE TABLE IF NOT EXISTS memberTB (
            number INT PRIMARY KEY AUTO_INCREMENT,
            name VARCHAR(100) NOT NULL,
            phone VARCHAR(30) NOT NULL,
            email VARCHAR(255) UNIQUE,
            id VARCHAR(30) UNIQUE,
            passwd VARCHAR(150) NOT NULL,
            regdate TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
            grade ENUM('일반', 'VIP', 'VVIP') DEFAULT '일반',
            addr VARCHAR(200) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ";

    // reservTB 테이블 생성
    $sql2 = "
        CREATE TABLE IF NOT EXISTS reservTB (
            reserv_n INT PRIMARY KEY AUTO_INCREMENT,
            number INT NOT NULL,
            name VARCHAR(100) NOT NULL,
            guest_phone VARCHAR(30) NOT NULL,
            branch ENUM('서울', '부산', '강릉', '제주') NOT NULL,
            check_in DATETIME NOT NULL,
            check_out DATETIME NOT NULL,
            room_id INT NOT NULL,
            room_t ENUM('룸(스탠다드)', '트룸(디럭스)', '트트룸(프리미엄)', '튼튼룸(VIP)') NOT NULL,
            guests INT NOT NULL,
            total_price DECIMAL(10, 2) NOT NULL,
            status ENUM('예약대기', '예약완료', '취소') DEFAULT '예약대기',
            reserv_date DATETIME NOT NULL,
            FOREIGN KEY (number) REFERENCES memberTB(number),
            FOREIGN KEY (room_id) REFERENCES roomTB(room_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ";

    // paymentTB 테이블 생성
    $sql3 = "
        CREATE TABLE IF NOT EXISTS paymentTB (
            id INT PRIMARY KEY AUTO_INCREMENT,
            reserv_n INT NOT NULL,
            total_price DECIMAL(10, 2) NOT NULL,
            pay_method ENUM('카드 결제', '무통장입금', '투스페이', '카카페이') NOT NULL,
            status ENUM('결제대기', '결제완료', '결제실패') DEFAULT '결제대기',
            pay_at TIMESTAMP,
            FOREIGN KEY (reserv_n) REFERENCES reservTB(reserv_n)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ";

    // 테이블 생성
    $pdo->exec($sql1);
    $pdo->exec($sql2);
    $pdo->exec($sql3);

    echo "모든 테이블이 성공적으로 생성되었습니다.";
} catch (PDOException $e) {
    echo "오류 발생: " . $e->getMessage();
}
?>
