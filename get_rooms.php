<?php
include('db_connection.php'); // 데이터베이스 연결 파일

// roomTB에서 객실 정보를 가져오기
$sql = "SELECT room_id, room_type FROM roomTB WHERE available_rooms > 0";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);

// JSON 형태로 결과 반환
echo json_encode($rooms);
?>
