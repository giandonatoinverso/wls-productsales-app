<?php

require_once 'config/config.php';
require_once BASE_PATH . '/lib/AuthManager/AuthManager.php';
session_start();

if (!isset($_SESSION['auth_manager']))
    $_SESSION['auth_manager'] = new AuthManager();

if(!$_SESSION['auth_manager']->getUserData() || !$_SESSION['auth_manager']->getScopes())
    $_SESSION['auth_manager']->startUserAuthentication();
else
    header("Location: index.php");

