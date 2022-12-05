<?php 
require_once(__DIR__ . '/../app/config.php');

Token::setToken();

// ログイン以降に他formに移らない処理
$result = UserLogic::checkLogin();
if ($result) {
  header('Location: mypage.php');
  return;
}

// mypage.phpエラー処理、三項演算子分岐
$login_err = isset($_SESSION['login_err']) ? $_SESSION['login_err'] : null;
unset($_SESSION['login_err']);

//新規登録入力バリデーションエラー
if (isset($_SESSION['signup_err'])) {
  $err = $_SESSION['signup_err'];
  unset($_SESSION['signup_err']);
}
if (isset($_SESSION['match_err'])) {
  $match_err = $_SESSION['match_err'];
  unset($_SESSION['match_err']);
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
  <title>新規登録</title>
</head>
<body class="text-center">
  <main class="form-signin w-100 m-auto">
    <h1 class="h3 mb-3 fw-normal">社員登録</h1>
      <?php if (isset($login_err)) : ?>
        <p><?= Utils::h($login_err); ?></p>
      <?php endif; ?>

      <?php if (isset($match_err)) : ?>
        <div class="alert2 alert-danger rounded" role="alert">
          <p><span class="small"><?= Utils::h($match_err); ?></span></p>
        </div>
      <?php endif; ?>
    <form action="signup.php" method="post">

      <div class="form-floating">
        <input type="text" name="name" class="form-control" id="floatingInput" placeholder="氏名">
        <label for="floatingInput">氏名</label>
        <?php if (isset($err['name_err'])) : ?>
          <div class="alert alert-danger rounded" role="alert">
            <span><?= Utils::h($err['name_err']); ?></span>
          </div>
        <?php endif; ?>
      </div>

      <div class="form-floating">
        <select class="form-select text-center" name="department" id="floatingInput">
          <option value="0">選択してください</option>
          <option value="１工場">１工場</option>
          <option value="２工場">２工場</option>
          <option value="技術">技術</option>
          <option value="事務所">事務所</option>
        </select>
        <label class="form-label" for="floatingInput">部署選択</label>
        <?php if (isset($err['department_err'])) : ?>
          <div class="alert alert-danger rounded" role="alert">
            <span><?= Utils::h($err['department_err']); ?></span>
          </div>
        <?php endif; ?>
      </div>
      
      <div class="form-floating">
        <input type="text" name="number" class="form-control" id="floatingInput" placeholder="社員番号">
        <label for="floatingInput">社員番号</label>
        <?php if (isset($err['number_err'])) : ?>
          <div class="alert alert-danger rounded" role="alert">
            <span><?= Utils::h($err['number_err']); ?></span>
          </div>
        <?php endif; ?>
      </div>

      <div class="form-floating">
        <input type="password" name="pass" class="form-control" id="floatingPassword" placeholder="パスワード">
        <label for="floatingPassword">パスワード</label>
        <?php if (isset($err['pass_err'])) : ?>
          <div class="alert2 alert-danger rounded" role="alert">
            <span class="small"><?= Utils::h($err['pass_err']); ?></span>
          </div>
        <?php endif; ?>
        <input type="hidden" name="csrf_token" value="<?= Utils::h($_SESSION["csrf_token"]); ?>">
      </div>

        <button class="w-100 btn btn-lg btn-primary btn-success" type="submit">サインイン</button>

    </form>
    <div class="mt-4">
      <a href="login_form.php"><button class="w-100 btn btn-lg btn-primary rounded-pill">ログインページ</button></a>
    </div>

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