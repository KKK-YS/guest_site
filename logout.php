<?php
session_start();
session_unset(); // 모든 세션 변수 제거
session_destroy(); // 세션 파괴

header('Location: index.html'); // 메인 페이지로 이동
exit();
