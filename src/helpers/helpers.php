<?php

function clearAuthCookies() {
	unset($_COOKIE['refreshToken']);
	unset($_COOKIE['refreshTokenExpiration']);
	setcookie('refreshToken', null, -1, '/');
	setcookie('refreshTokenExpiration', null, -1, '/');
}

function clearUserCookies() {
    unset($_COOKIE['userData']);
    unset($_COOKIE['scopes']);
    setcookie('userData', null, -1, '/');
    setcookie('scopes', null, -1, '/');
}

function base_url(){
    return sprintf(
        "%s://%s:%s",
        isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
        $_SERVER['SERVER_NAME'],
        $_SERVER['SERVER_PORT']
    );
}
