<?php
require_once(__DIR__ . '/../app/config.php');

$validate = [];
$err = [];

// ログインバリデーション
$err = ValidateForm::setForm($_POST);
// エラーカウント
if (count($err) > 0) {
  $_SESSION['login_err'] = $err;
  header('Location: login_form.php');
  return;
}
$validate = ValidateForm::setLogin($_POST);
$user = $validate['employee'];
$password = $validate['mypass'];
// ログイン成功処理
$result = UserLogic::Login($user, $password);
// ログイン失敗処理
if (empty($result)) {
  header('Location: login_form.php');
  return;
} else {
  unset($_SESSION['signup_err']);
  unset($_SESSION['login_err']);
  unset($_SESSION['message']);
  header('Location: mypage2.php');
  exit();
}
