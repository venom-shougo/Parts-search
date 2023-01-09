<?php
require_once(__DIR__ . '/../app/config.php');

/**
 * パーツ注文詳細をExcelで出力処理
 */

$history = $_SESSION['history'];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  ExcelLogic::Excelout($history);
}
