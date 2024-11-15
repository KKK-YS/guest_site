<?php
include('db_connection.php'); // 데이터베이스 연결 파일

// 입력된 데이터 가져오기
$branch = $_POST['branch'];
$roomType = $_POST['roomType'];
$checkInDate = $_POST['checkInDate'];
$checkOutDate = $_POST['checkOutDate'];

// 예약 가능한 방 조회
$sql = "SELECT room_id FROM 객실현황 
        WHERE branch = ? AND room_type = ? 
        AND date BETWEEN ? AND ? 
        AND availability = 'available'";
$stmt = $pdo->prepare($sql);
$stmt->execute([$branch, $roomType, $checkInDate, $checkOutDate]);
$availableRooms = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 결과 반환
if (count($availableRooms) > 0) {
    // 예약 가능한 방이 있을 경우 JSON 형식으로 room_id 목록 반환
    echo json_encode([
        'status' => 'available',
        'rooms' => $availableRooms
    ]);
} else {
    // 예약 가능한 방이 없는 경우
    echo json_encode(['status' => 'unavailable']);
}
?>
