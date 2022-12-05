<?php

session_start();

define('DSN' ,'mysql:host=db;dbname=myapp;charset=utf8mb4');
define('DB_USER', 'myappuser');
define('DB_PASS', 'myapppass');

// define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST']);
ini_set('display_errors', 'Off');
ini_set('log_errors', 'On');
ini_set('error_log', '/work/app/error_log/php_errors.log');
// ini_set('error_log', 'errors.log');
// phpinfo();

// adminユーザかチェック
$login_user = $_SESSION['login_user'];
if ($login_user['name'] === 'admin') {
    $admin = true;
}

require_once(__DIR__ . '/Database.php');
require_once(__DIR__ . '/MySql.php');
require_once(__DIR__ . '/Validation.php');
require_once(__DIR__ . '/UserLogic.php');
require_once(__DIR__ . '/PartsValidation.php');
require_once(__DIR__ . '/PartsLogic.php');
require_once(__DIR__ . '/ImageAcqu.php');
require_once(__DIR__ . '/OrderValidation.php');
require_once(__DIR__ . '/OrderLogic.php');
require_once(__DIR__ . '/Pagination.php');
require_once(__DIR__ . '/Utils.php');
require_once(__DIR__ . '/Conversion.php');
require_once(__DIR__ . '/Token.php');
require_once(__DIR__ . '/Excel.php');
require_once(__DIR__ . '/Errors.php');

// GetError::Errors();
