<?php

require_once(__DIR__ . '/../app/config.php');

// ログイン以降に他formに移らない処理
$result = UserLogic::checkLogin();
if ($result) {
  header('Location: mypage.php');
  return;
}

// ログインバリデーションエラーの処理
if (isset($_SESSION['login_err'])) {
  $err = $_SESSION['login_err'];
  unset($_SESSION['login_err']);
}
if (isset($_SESSION['message'])) {
  $err = $_SESSION;
  unset($_SESSION['message']);
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
  <link rel="stylesheet" href="css/sign.css">
  <link rel="stylesheet" href="css/bootstrap.css">
  <title>ログイン</title>
</head>
<body class="text-center">
  <main class="form-signin w-100 m-auto">
    <h1 class="h3 mb-3 fw-normal">ログインフォーム</h1>
    <form action="login.php" method="post">
      <div class="form-floating">
        <input type="text" name="employee" class="form-control" id="floatingInput" placeholder="社員番号">
        <label for="floatingInput">社員番号</label>
        <?php if (isset($err['empl_err'])) : ?>
          <div class="alert alert-danger rounded" role="alert">
            <p><span class="small"><?= Utils::h($err['empl_err']); ?></span></p>
          </div>
        <?php endif; ?>
        </div>
        <div class="form-floating">
          <input type="password" name="mypass" class="form-control" id="floatingPassword" placeholder="パスワード">
          <label for="floatingPassword">パスワード</label>
        <?php if (isset($err['mypass_err'])) : ?>
          <div class="alert alert-danger rounded" role="alert">
            <p><span class="small"><?= Utils::h($err['mypass_err']);?></span></p>
          </div>
        <?php endif; ?>
        <?php if (isset($err['message'])) : ?>
          <div class="alert alert-danger rounded" role="alert">
            <p><span class="small"><?= Utils::h($err['message']); ?></span></p>
          </div>
        <?php endif; ?>
      </div>
      <button class="w-100 btn btn-lg btn-primary btn-success" type="submit">ログイン</button>
    </form>
    <a class="lead" href="signup_form.php"><button class="w-100 mt-4 btn btn-lg btn-primary rounded-pill">社員登録</button></a>
    <div class="container">
      <footer class="py-3 my-4">
        <ul class="nav justify-content-center border-bottom pb-3 mb-3">
          
        </ul>
        <p class="text-center text-muted">&copy; SHOWA INK 1932-2022</p>
      </footer>
    </div>
  </main>
  <script src="js/bootstrap.js"></script>
</body>
</html>

