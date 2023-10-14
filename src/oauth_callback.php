<?php
require_once 'config/config.php';
require_once BASE_PATH . '/lib/AuthManager/AuthManager.php';
session_start();


if($_SERVER["REQUEST_METHOD"] !== "GET")
    die("Method not allowed");

$_SESSION['auth_manager'] = new AuthManager();
if(isset($_GET["authorizationCodeEncoded"]) && isset($_GET["username"])) {
    $result = $_SESSION['auth_manager']->exchangeAuthorizationCodeAccessToken(base64_decode($_GET["authorizationCodeEncoded"]));
    $_SESSION['auth_manager']->setScopes($result["accessToken"], $result["refreshTokenExpiration"]);

    $access_token = $_SESSION['auth_manager']->getAccessToken($result["refreshToken"]);
    $_SESSION['auth_manager']->setUserData(base64_decode($_GET["username"]), $access_token, $result["refreshTokenExpiration"]);

    $_SESSION['user_logged_in'] = true;

    header("Location: index.php");
} else if(isset($_GET["deny"])) {
    $_SESSION['auth_manager']->failure("Autorizzazione non concessa", "index.php");
}