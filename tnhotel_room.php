<?php
// 데이터베이스 연결 설정
$host = '115.31.96.2';
$dbname = 'tnhotelDB';
$user = 'hotel'; // 데이터베이스 사용자명
$pass = '1234'; // 데이터베이스 비밀번호

try {
    // 데이터베이스 연결
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 객실 현황 테이블 생성 SQL
    $createTableSql = "
        CREATE TABLE IF NOT EXISTS roomTB (
            room_id INT PRIMARY KEY AUTO_INCREMENT,               -- Primary Key
            branch ENUM('서울', '부산', '강릉', '제주') NOT NULL,
            room_type ENUM('룸(스탠다드)', '트룸(디럭스)', '트트룸(프리미엄)', '튼튼룸(VIP)') NOT NULL,
            total_rooms INT NOT NULL,
            available_rooms INT NOT NULL,
            room_status ENUM('예약 가능', '예약 중', '청소 중') DEFAULT '예약 가능',
            current_pay DECIMAL(10, 2) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ";
    
    $pdo->exec($createTableSql);

    // 각 지점의 객실 초기화 정보
    $branches = [
        '서울' => ['룸(스탠다드)' => 161, '트룸(디럭스)' => 121, '트트룸(프리미엄)' => 81, '튼튼룸(VIP)' => 40],
        '강릉' => ['룸(스탠다드)' => 89, '트룸(디럭스)' => 66, '트트룸(프리미엄)' => 44, '튼튼룸(VIP)' => 22],
        '부산' => ['룸(스탠다드)' => 155, '트룸(디럭스)' => 116, '트트룸(프리미엄)' => 77, '튼튼룸(VIP)' => 39],
        '제주' => ['룸(스탠다드)' => 162, '트룸(디럭스)' => 122, '트트룸(프리미엄)' => 82, '튼튼룸(VIP)' => 41]
    ];

    // 테이블 초기화: 각 지점별 객실 데이터 삽입
    $insertSql = "INSERT INTO roomTB (branch, room_type, total_rooms, available_rooms) VALUES (:branch, :room_type, :total_rooms, :available_rooms)";
    $stmt = $pdo->prepare($insertSql);

    foreach ($branches as $branch => $rooms) {
        foreach ($rooms as $roomType => $totalRooms) {
            $stmt->execute([
                ':branch' => $branch,
                ':room_type' => $roomType,
                ':total_rooms' => $totalRooms,
                ':available_rooms' => $totalRooms
            ]);
        }
    }

    echo "roomTB 테이블이 성공적으로 생성되고 데이터가 초기화되었습니다.";

} catch (PDOException $e) {
    echo "오류 발생: " . $e->getMessage();
}
?>
