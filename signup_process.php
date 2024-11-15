<?php
// signup_process.php
include('db_connection.php'); // 데이터베이스 연결 파일

// 데이터베이스를 tnhotelDB로 설정
$pdo->exec("USE tnhotelDB");

$message = ''; // 메시지 초기화

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $id = $_POST['id'];
    $passwd = $_POST['passwd'];
    $addr = $_POST['addr'];

    // 입력값 검증 (예: 빈 값 체크)
    if (empty($name) || empty($passwd) || empty($email) || empty($id) || empty($phone) || empty($addr)) {
        $message = "모든 필드를 채워주세요.";
    } else {
        // 중복 사용자 확인
        $checkSql = "SELECT COUNT(*) FROM memberTB WHERE iD = ?";
        $checkStmt = $pdo->prepare($checkSql);
        $checkStmt->execute([$id]);
        $userExists = $checkStmt->fetchColumn();

        if ($userExists > 0) {
            $message = "이미 사용 중인 ID입니다. 다른 ID를 선택해 주세요.";
        } else {
            // 비밀번호 해싱
            $hashed_password = password_hash($passwd, PASSWORD_DEFAULT);

            // 새로운 사용자 정보를 데이터베이스에 삽입
            $sql = "INSERT INTO memberTB (name, phone, email, iD, passwd, addr) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);

            try {
                if ($stmt->execute([$name, $phone, $email, $id, $hashed_password, $addr])) {
                    $message = "회원가입 완료되었습니다"; // 성공 메시지 저장
                } else {
                    $message = "회원가입 실패. 다시 시도해 주세요.";
                }
            } catch (PDOException $e) {
                $message = "회원가입 중 오류 발생: " . $e->getMessage();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>회원가입 결과</title>
    <style>
        body {
            font-family: 'Noto Sans KR', sans-serif;
            background-color: #e6f4e6; /* 부드러운 초록 배경색 */
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .message-container {
            background-color: #ffffff;
            border: 1px solid #4CAF50; /* 초록색 테두리 */
            padding: 30px;
            border-radius: 10px;
            width: 360px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .message-container h1 {
            font-size: 20px;
            color: #2e7d32; /* 제목 초록색 */
            margin-bottom: 15px;
        }
        .message {
            font-size: 16px;
            color: #388e3c; /* 텍스트 초록색 */
            margin-bottom: 20px;
        }
        .error {
            color: #e74c3c; /* 에러 색상 */
        }
        .success {
            color: #4caf50; /* 성공 색상 */
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50; /* 초록색 버튼 */
            color: white;
            text-decoration: none;
            font-weight: bold;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .button:hover {
            background-color: #388e3c; /* 버튼 호버 시 더 어두운 초록 */
        }
    </style>
</head>
<body>
    <div class="message-container">
        <h1>회원가입 결과</h1>
        <?php if (!empty($message)): ?>
            <p class="message <?php echo strpos($message, '완료되었습니다') !== false ? 'success' : 'error'; ?>">
                <?php echo $message; ?>
            </p>
            <?php if ($message === "회원가입 완료되었습니다"): ?>
                <script>
                    setTimeout(function() {
                        window.location.href = 'login.html';
                    }, 3000); // 3초 후 로그인 페이지로 이동
                </script>
            <?php endif; ?>
        <?php endif; ?>
        <a href="signup.html" class="button">돌아가기</a>
    </div>
</body>
</html>

