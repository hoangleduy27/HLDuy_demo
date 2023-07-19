<?php
session_start();

// Xóa tất cả các biến session
$_SESSION = array();

// Hủy bỏ session hiện tại
session_destroy();

// Xóa các cookie session nếu có
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 3600,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Chuyển hướng người dùng đến trang đăng nhập
header('Location: ../login/Login.php');
exit();
