<?php

function clearAuthCookies() {
	unset($_COOKIE['refreshToken']);
	unset($_COOKIE['refreshTokenExpiration']);
    setcookie('refreshToken', '', time() - 3600, '/');
    setcookie('refreshTokenExpiration', '', time() - 3600, '/');
}

function clearUserCookies() {
    unset($_COOKIE['userData']);
    unset($_COOKIE['scopes']);
    setcookie('userData', '', time() - 3600, '/');
    setcookie('scopes', '', time() - 3600, '/');
}

function base_url(){
    return sprintf(
        "%s://%s:%s",
        isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
        $_SERVER['SERVER_NAME'],
        $_SERVER['SERVER_PORT']
    );
}
?>