<?php

require_once(__DIR__ . '/../app/config.php');


// トークン照会
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  Token::validateToken();
}
unset($_SESSION['csrf_token']);

//パーツ登録か編集を分岐
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!empty($_POST['register'])) {
    $confirm = $_POST;
    unset($_SESSION['err']);
    //同じパーツ登録確認処理
    $checked = PartsLogic::checkParts($confirm);
    //パーツ登録処理
    !empty($checked) ? $_SESSION['checked_err'] = '部品はすでに登録されてます' : $result = PartsLogic::createParts($confirm);
    header('Location: register.php?get');
    return;
  } else {
    //パーツ編集処理
    $edit = $_POST;
    //次は編集登録中のパーツアクセスをブロックする処理を実装する
    !empty($edit) ? $result = PartsLogic::createParts($edit) : $result = false;
  }
}

//登録成功合否判定
if (!empty($result)) {
  $success = '登録しました';
} else {
  $err = [];
  $err[] = '登録に失敗しました';
  }

include('_header.php');

?>

  <main>
    <?php if (count($err) > 0) : ?>
      <form action="register_form.php" method="post">
          <?php foreach ($err as $e) : ?>
            <p class="h5 alert alert-danger text-center"><?= Utils::h($e); ?></p>
          <?php endforeach; ?>
          <div class="container text-center">
            <div class="d-flex flex-row-reverse">
              <button class="btn btn-primary rounded-pill" type="submit">戻る</button>
            </div>
          </div>
      </form>
    <?php else : ?>
    <h1 class="h3 mb-3 mt-5 fw-normal text-center"><?= Utils::h($success); ?></h1>
      <form action="mypage.php" method="get">
        <div class="container text-center">
          <div class="d-flex flex-row-reverse">
            <button class="btn btn-primary rounded-pill">マイページ</button>
          </div>
        </div>
      </form>
    <?php endif; ?>
  </main>

<?php
  include('_footer.php');
