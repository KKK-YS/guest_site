<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>튼튼호텔 - 직원 로그인</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="login-container">
        <h2>튼튼호텔 직원 로그인</h2>
        <form action="dashboard.php" method="POST">
            <input type="text" name="username" placeholder="ID" required>
            <input type="password" name="password" placeholder="비밀번호" required>
            <button type="submit">로그인</button>
        </form>
    </div>
</body>
</html>
