<?php
require_once(__DIR__ . '/../app/config.php');

$history = $_SESSION['history'];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  ExcelLogic::Excelout($history);
}