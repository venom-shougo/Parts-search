<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css?family=M+PLUS+Rounded+1c" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/mypage.css">
  <title>部品探して注文アプリ</title>
</head>
<body>
<main>
  <header class="p-3 mb-3 border-bottom bg-light2 bg-gradient">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <span class="fs-4 d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">部品検索>注文アプリ</span>

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
          <li><a href="register_form.php" class="nav-link">部品登録</a></li>
          <form action="get_history.php" method="get">
            <input type="hidden" name="page">
            <li><a href="get_history.php" class="nav-link">注文履歴</a></li>
          </form>
          <li><a href="#" class="nav-link px-2 link-dark">在庫</a></li>
        </ul>

        <div class="dropdown text-end">
          <a href="#" class="fs-4 d-block link-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-person-circle"></i><?= Utils::h($login_user['number']); ?></a>
          <ul class="dropdown-menu text-small">
            <!-- <li><hr class="dropdown-divider"></li> -->
            <li>
              <form action="logout.php" method="post">
                <input class="input-btn" type="submit" name="logout" value="ログアウト">
              </form>
            </li>
            <li>
              <form action="deleteuser.php" method="post">
                <input class="input-btn" type="submit" name="deleteuser" value="アカウント削除">
              </form>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </header>
