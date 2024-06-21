<?php
// Mulai session (harus dilakukan di awal setiap halaman yang menggunakan session)
session_start();

// Unset semua variabel session
$_SESSION = array();

// Hapus session cookie jika ada
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Hancurkan session
session_destroy();

// Redirect ke halaman login
header("Location: index.php");
exit;
?>