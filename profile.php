<?php
session_start();

// 로그인 여부 확인
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html'); // 로그인되지 않은 경우 로그인 페이지로 이동
    exit();
}

// 데이터베이스 연결
include('db_connection.php');

// 사용자 정보 가져오기
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM memberTB WHERE number = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if (!$user) {
    echo "사용자 정보를 가져올 수 없습니다.";
    exit();
}

// 수정 폼 제출 처리
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // 데이터베이스 업데이트
    $update_sql = "UPDATE memberTB SET name = ?, email = ?, phone = ? WHERE number = ?";
    $update_stmt = $pdo->prepare($update_sql);
    $update_stmt->execute([$name, $email, $phone, $user_id]);

    echo "<script>alert('회원 정보가 수정되었습니다.'); window.location.href='profile.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>회원 정보 수정</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fff9e6;
            color: #4a4a4a;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        
        .container {
            width: 400px;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #4caf50;
            font-size: 2em;
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-top: 10px;
        }

        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #4caf50;
            color: white;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
        }

        button:hover {
            background-color: #45a049;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 15px;
            text-decoration: none;
            color: #4a4a4a;
        }

        .back-link:hover {
            color: #4caf50;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>회원 정보 수정</h1>
        <form method="POST">
            <label for="name">이름:</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($user['name']); ?>" required>

            <label for="email">이메일:</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']); ?>" required>

            <label for="phone">전화번호:</label>
            <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($user['phone']); ?>" required>

            <button type="submit">수정하기</button>
        </form>
        <a href="index.html" class="back-link">메인 페이지로 돌아가기</a>
    </div>
</body>
</html>
