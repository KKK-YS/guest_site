<?php
session_start();
header('Content-Type: application/json');

// 로그인 상태 확인
if (isset($_SESSION['user_id'])) {
    echo json_encode([
        'loggedIn' => true,
        'username' => $_SESSION['username']
    ]);
} else {
    echo json_encode(['loggedIn' => false]);
}
?>
