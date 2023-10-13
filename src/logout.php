<?php
require_once './config/config.php';
session_start();
session_destroy();

if(isset($_COOKIE['refreshToken']) && isset($_COOKIE['refreshTokenExpiration'])){
	clearAuthCookies();
}

if(isset($_COOKIE['userData']) && isset($_COOKIE['scopes'])){
    clearUserCookies();
}

header('Location: index.php');
exit;

 ?>
