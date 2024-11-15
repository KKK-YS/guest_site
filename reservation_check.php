<!-- 예약 확인 페이지: reservation_check.php -->
<?php
session_start();

include('db_connection.php'); // 데이터베이스 연결 파일

// 로그인 확인
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('로그인이 필요합니다.'); window.location.href='login.html';</script>";
    exit();
}

$userId = $_SESSION['user_id'];

// 사용자 예약 정보 조회
$stmt = $pdo->prepare("SELECT * FROM reservTB WHERE number = ?");
$stmt->execute([$userId]);
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>예약 확인</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fff9e6;
            margin: 0;
            color: #4a4a4a;
        }
        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .home-button {
            background-color: #4caf50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
            text-align: center;
            display: inline-block;
            margin-bottom: 20px;
            text-decoration: none;
        }
        .home-button:hover {
            background-color: #66bb6a;
        }
        h2 {
            color: #4caf50;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f0ad4e;
            color: white;
        }
        td {
            text-align: center;
        }
        .no-reservation {
            font-size: 1.2em;
            color: #666;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- 홈 버튼 추가 -->
        <a href="index.html" class="home-button">홈으로</a>

        <h2>예약 확인</h2>
        <?php if (count($reservations) > 0): ?>
            <table>
                <tr>
                    <th>예약번호</th>
                    <th>지점</th>
                    <th>체크인 날짜 및 시간</th>
                    <th>체크아웃 날짜 및 시간</th>
                    <th>객실 유형</th>
                    <th>인원 수</th>
                    <th>총 결제 금액</th>
                    <th>상태</th>
                </tr>
                <?php foreach ($reservations as $reservation): ?>
                    <tr>
                        <td><?= htmlspecialchars($reservation['reserv_n']) ?></td>
                        <td><?= htmlspecialchars($reservation['branch']) ?></td>
                        <td><?= htmlspecialchars(date("Y-m-d", strtotime($reservation['check_in']))) ?> 13:00</td>
                        <td><?= htmlspecialchars(date("Y-m-d", strtotime($reservation['check_out']))) ?> 11:00</td>
                        <td><?= htmlspecialchars($reservation['room_t']) ?></td>
                        <td><?= htmlspecialchars($reservation['guests']) ?>명</td>
                        <td><?= number_format(htmlspecialchars($reservation['total_price'])) ?>원</td>
                        <td><?= htmlspecialchars($reservation['status']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p class="no-reservation">예약 내역이 없습니다.</p>
        <?php endif; ?>
    </div>
</body>
</html>
