<?php

require_once(__DIR__ . '/../vendor/autoload.php');

session_start();

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

define('DSN' , $_ENV['DSN']);
define('DB_USER', $_ENV['DB_USER']);
define('DB_PASS', $_ENV['DB_PASS']);

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

const TOTAL_RECORDS_PER_PAGE = '5';
const NUMBER_OF_ERRORS = 0;

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
