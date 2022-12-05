<?php

require_once(__DIR__ . '/../app/config.php');

$err = [];

// ポスト値が空だったらエラー出力
if (!$deleteuser = filter_input(INPUT_POST, 'deleteuser')) {
  exit('Invalid post request');
}

// ログイン判定、セッション切れ、ログイン要求
// セッション有効期限はデフォルトで24分
// MyPageで何もしなかったらセッションが切れる
$result = UserLogic::checkLogin();
if (!$result) {
  $err = 'Expired,please log in again' . "\n" . '<a href="login_form.php">Login Page</a>';
  $err = nl2br($err);
  exit($err);
}

// 退会処理
$deleteuser = UserLogic::deleteuser();
if (!$deleteuser) {
  $err[] = 'Withdrawal failure';
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css?family=M+PLUS+Rounded+1c" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="css/mypage.css">
  <link rel="stylesheet" href="css/bootstrap.css">
  <title>Withdrawal</title>
</head>
<body>
<div class="container">
    <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
      <a href="/" class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">
        <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"/></svg>
      </a>

      <h4 class="title-center">部品検索App</h4>

      <div class="col-md-3 text-end">
        <a href="login_form.php"><button type="button" class="btn btn-outline-primary me-2">ログイン</button></a>
        <a href="signup_form.php"><button type="button" class="btn btn-primary">サインアップ</button></a>
      </div>
    </header>
  </div>
  <?php if (count($err) > 0) : ?>
    <?php foreach ($err as $e) : ?>
      <?= Utils::h($e); ?>
    <?php endforeach; ?>
  <?php else : ?>
  <div class="text-center">
    <main class="form-signin w-100 m-auto">
      <h2 class="h3 mb-3 fw-normal">ユーザー削除完了</h2>
    </main>
  </div>
  <?php endif; ?>

<?php
  include('_footer.php');