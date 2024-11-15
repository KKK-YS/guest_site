<?php
// 데이터베이스 연결 설정
$host = '115.31.96.2';
$dbname = 'tnhotelDB';
$user = 'hotel';
$pass = '1234';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 객실 데이터 초기화
    $branches = [
        '서울' => ['룸(스탠다드)' => 161, '트룸(디럭스)' => 121, '트트룸(프리미엄)' => 81, '튼튼룸(VIP)' => 40],
        '강릉' => ['룸(스탠다드)' => 89, '트룸(디럭스)' => 66, '트트룸(프리미엄)' => 44, '튼튼룸(VIP)' => 22],
        '부산' => ['룸(스탠다드)' => 155, '트룸(디럭스)' => 116, '트트룸(프리미엄)' => 77, '튼튼룸(VIP)' => 39],
        '제주' => ['룸(스탠다드)' => 162, '트룸(디럭스)' => 122, '트트룸(프리미엄)' => 82, '튼튼룸(VIP)' => 41]
    ];

    // roomTB에 객실 데이터 삽입
    foreach ($branches as $branch => $rooms) {
        foreach ($rooms as $roomType => $totalRooms) {
            $insertSql = "INSERT INTO roomTB (branch, room_type, total_rooms, available_rooms, room_status, current_pay) VALUES (?, ?, ?, ?, '예약 가능', 0)";
            $stmt = $pdo->prepare($insertSql);
            $stmt->execute([$branch, $roomType, $totalRooms, $totalRooms]);
        }
    }

    echo "모든 객실 데이터가 성공적으로 삽입되었습니다.";
} catch (PDOException $e) {
    echo "오류 발생: " . $e->getMessage();
}
?>
