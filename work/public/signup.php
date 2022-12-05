<?php

require_once(__DIR__ . '/../app/config.php');

// トークン照会
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  Token::validateToken();
}
unset($_SESSION['csrf_token']);

$err = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $signup = $_POST;
}
// var_dump($signup);
// exit;
// サインアップフォームバリデーション
$err = ValidateForm::setSignup($signup);
// var_dump($err);
// exit;
// エラー無しで同ユーザチェック
if (count($err) > 0) {
  $_SESSION['signup_err'] = $err;
  header('Location: signup_form.php');
  return;
} else {
  unset($_SESSION['signup_err']);
}

//同ユーザ判定
$checked = UserLogic::checkUser($signup);
// var_dump($checked);
// exit;
  if($checked === true) {
  // checkedがtrueだったら同じユーザ名エラー
    $_SESSION['match_err'] = '氏名または社員番号がすでに登録されてます';
    header('Location: signup_form.php');
    return;
  } else {
  // checkedがfalseだったらユーザー登録
    $hasCreated = UserLogic::createUser($signup);
    if (empty($hasCreated)) {
      $err[] = 'もう一度やり直してください';
    }
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
  <title>登録完了</title>
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
  <div  class="text-center">
    <main class="form-signin w-100 m-auto">
      <!-- <div class="container"> -->
        <form action="signup_form.php" method="post">
          <?php if (count($err) > 0) : ?>
            <?php foreach ($err as $e) : ?>
              <p class="h4 text-center"><?= Utils::h($e); ?></p>
            <?php endforeach; ?>
          <div class="container text-center">
            <div class="d-flex flex-row-reverse">
              <button class="btn btn-primary rounded-pill mt-5">戻る</button>
            </div>
          </div>
        </form>
          <?php else : ?>
            <h1 class="h3 mb-3 fw-normal text-center">登録完了</h1>
            <p class="text-center">ログインしてください</p>
          <?php endif; ?>
      <!-- </div> -->
      <div class="container">
        <footer class="py-3 my-4">
          <ul class="nav justify-content-center border-bottom pb-3 mb-3">
            </ul>
            <p class="text-center text-muted">&copy; SHOWA INK 1932-2022</p>
        </footer>
      </div>
    </main>
  </div>
  <script src="js/bootstrap.js"></script>
  <script src="js/bootstrap.bundle.js"></script>
</body>
</html>
