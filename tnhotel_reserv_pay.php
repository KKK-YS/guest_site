<?php
// 데이터베이스 연결
include('db_connection.php'); // 데이터베이스 연결 파일

try {
    // 1. paymentTB 테이블 생성
    $paymentSql = "CREATE TABLE IF NOT EXISTS paymentTB (
        id INT PRIMARY KEY AUTO_INCREMENT,
        reserv_n INT NOT NULL,
        amount DECIMAL(10, 2) NOT NULL,
        pay_method ENUM('카드 결제', '무통장입금', '투스페이', '카카페이'),
        status ENUM('결제대기', '결제완료', '결제실패'),
        pay_at TIMESTAMP,
        FOREIGN KEY (reserv_n) REFERENCES reservTB(reserv_n)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
    $pdo->exec($paymentSql);
    echo "paymentTB 테이블 생성 완료.<br>";

    // 2. reservTB 테이블 생성
    $reservSql = "CREATE TABLE IF NOT EXISTS reservTB (
        reserv_n INT PRIMARY KEY AUTO_INCREMENT,
        number INT NOT NULL,
        guest_phone VARCHAR(30) NOT NULL,
        name VARCHAR(100) NOT NULL,
        id VARCHAR(30) NOT NULL,
        reserv_date DATETIME,
        check_in DATETIME NOT NULL,
        check_out DATETIME NOT NULL,
        guests INT NOT NULL,
        room_id INT NOT NULL,
        room_t ENUM('룸(스탠다드)', '트룸(디럭스)', '트트룸(프리미엄)', '튼튼룸(VIP)'),
        total_price DECIMAL(10, 2) NOT NULL,
        payment_id INT NOT NULL,
        status ENUM('결제대기', '확인중', '예약확정', '취소'),
        FOREIGN KEY (number) REFERENCES jjakDB.memberTB(number),
        FOREIGN KEY (payment_id) REFERENCES paymentTB(id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
    $pdo->exec($reservSql);
    echo "reservTB 테이블 생성 완료.<br>";

} catch (PDOException $e) {
    echo "테이블 생성 오류: " . $e->getMessage();
}
?>
