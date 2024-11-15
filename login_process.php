<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include('db_connection.php'); // 데이터베이스 연결 파일

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // 데이터베이스에서 사용자 조회
    $sql = "SELECT * FROM memberTB WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    // 사용자가 존재하고, 비밀번호가 일치하는지 확인
    if ($user && password_verify($password, $user['passwd'])) {
        $_SESSION['user_id'] = $user['number']; // 사용자 고유번호 저장
        $_SESSION['username'] = $user['name'];   // 사용자 이름 저장

        // 로그인 성공 시 메인 페이지로 리디렉션
        header('Location: index.html');
        exit();
    } else {
        echo "<script>alert('아이디 또는 비밀번호가 잘못되었습니다.'); history.back();</script>";
    }
}
?>
