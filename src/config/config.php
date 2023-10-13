<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');
define('BASE_PATH', dirname(dirname(__FILE__)));
define('CURRENT_PAGE', basename($_SERVER['REQUEST_URI']));

require_once BASE_PATH . '/helpers/helpers.php';

define('CURRENT_FOLDER', base_url());
define('WHOLESALES_SERVER', getenv("WHOLESALES_SERVER"));
define('OAUTH_SERVER', getenv("OAUTH_SERVER"));
define('OAUTH_FRONTEND', getenv("OAUTH_FRONTEND"));
define('CLIENT_ID', getenv("CLIENT_ID"));
define('CLIENT_SECRET', getenv("CLIENT_SECRET"));
