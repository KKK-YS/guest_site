<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include('db_connection.php'); // 데이터베이스 연결 파일

// 세션에서 사용자 ID 가져오기
$number = $_SESSION['user_id'] ?? null; // 로그인한 사용자의 ID (memberTB의 number)

// POST 데이터 가져오기
$name = $_POST['name'] ?? null;
$guest_phone = $_POST['guest_phone'] ?? null;
$branch = $_POST['branch'] ?? null;
$room_t = $_POST['room_t'] ?? null;
$check_in = $_POST['check_in'] ?? null;
$check_out = $_POST['check_out'] ?? null;
$guests = $_POST['guests'] ?? null;
$total_price = $_POST['total_price'] ?? 0;

// 사용자 ID가 없는 경우 오류 처리
if (!$number) {
    echo "로그인 정보가 필요합니다.";
    exit();
}

try {
    // 트랜잭션 시작
    echo "트랜잭션 시작<br>";
    $pdo->beginTransaction();

    // 1. 예약 가능한 객실 확인
    $stmt = $pdo->prepare("SELECT room_id, available_rooms FROM roomTB WHERE branch = ? AND room_type = ? AND available_rooms > 0 LIMIT 1");
    $stmt->execute([$branch, $room_t]);
    $room = $stmt->fetch();

    if (!$room) {
        throw new Exception("선택하신 지점 및 객실 유형에 예약 가능한 방이 없습니다.");
    }

    $room_id = $room['room_id'];
    echo "예약 가능한 객실 ID: $room_id<br>";

    // 2. 예약 정보 추가
    $stmt = $pdo->prepare("INSERT INTO reservTB (number, name, guest_phone, branch, check_in, check_out, guests, room_id, room_t, total_price, status) 
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, '예약완료')");
    $stmt->execute([$number, $name, $guest_phone, $branch, $check_in, $check_out, $guests, $room_id, $room_t, $total_price]);

    // 방금 추가된 예약 ID 가져오기
    $reserv_id = $pdo->lastInsertId();

    // 3. 결제 정보 추가
    $payment_method = '카드 결제'; // 결제 수단은 예시로 카드 결제를 사용
    $stmt = $pdo->prepare("INSERT INTO paymentTB (reserv_n, total_price, pay_method, status, pay_at) VALUES (?, ?, ?, '결제완료', NOW())");
    $stmt->execute([$reserv_id, $total_price, $payment_method]);

    echo "결제 정보가 성공적으로 추가되었습니다.<br>";

    // 4. roomTB에서 객실의 available_rooms 감소 및 상태 업데이트
    $stmt = $pdo->prepare("UPDATE roomTB SET available_rooms = available_rooms - 1, room_status = '예약 중' WHERE room_id = ?");
    $stmt->execute([$room_id]);

    // 트랜잭션 커밋
    $pdo->commit();
    echo "<script>alert('예약이 완료되었습니다.'); window.location.href='index.html';</script>";
} catch (Exception $e) {
    // 트랜잭션 롤백 및 오류 메시지 출력
    $pdo->rollBack();
    echo "예약 중 오류가 발생했습니다: " . $e->getMessage();
    exit();
}
