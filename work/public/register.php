<?php

require_once(__DIR__ . '/../app/config.php');

Token::setToken();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  //再登録防止処理
  if (!isset($_SESSION['count'])) {
    $_SESSION['count'] = 1;
  } else {
    $count = $_SESSION['count'];
    $count ++;
    $_SESSION['count'] = $count;
  }
} elseif (!empty($_SESSION['checked_err'])) {
  header('Location: mypage.php');
  exit();
} else {
  $_SESSION['count'] = 0;
}

//画像登録エラーが無ければページカウンター判定
if (empty($_SESSION['imgdir_err'])) {
  if ($_SESSION['count'] > 1) {
    header('Location: mypage.php');
    exit();
  }
}

$err = [];
// 登録後同名パーツエラー処理
if (isset($_SESSION['checked_err'])) {
  $checked_err = $_SESSION['checked_err'];
  // unset($_SESSION['checked_err']);
  $confirm = $_SESSION['register'];
} else {
  //登録パーツバリデーション
  $err = PartsValidateForm::setParts($_POST);
}

// エラーカウント
if (count($err) > 0) {
  $_SESSION['err'] = $err;
  header('Location: register_form.php');
  return;
}

$showimg = ImageAcqu::imageDisp();

//パーツフォーム入力後POST処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $confirm = $_POST;
  $_SESSION['register'] = $confirm;
  //画像セッション保存
  unset($_SESSION['imgdir_err']);
  $imgresult = ImageAcqu::createImage($confirm);
  //画像データ保存成功判定
  if (!empty($imgresult)) {
  } else {
    header('Location: register_form.php');
    return;
  }
}

include('_header.php');

?>

  <main>
    <div class="container">
      <h1 class="h3 mb-3 fw-normal text-center">入力確認</h1>
      <?php if (empty($checked_err)) : ?>
        <p class="h5 alert alert-warning text-center rounded">入力に間違いがないかご確認ください</p>
      <?php else : ?>
        <p class="h5 alert alert-danger text-center"><?= Utils::h($checked_err); ?></p>
      <?php endif; ?>
      <form action="record.php" method="post">
        <table class="table table-striped">
          <tr>
            <td>部品名</td><td><?= Utils::h($confirm['parts_name']); ?></td>
            <input type="hidden" name="parts_name" value="<?= Utils::h($confirm['parts_name']); ?>">
          </tr>
          <tr>
            <td>メーカー</td><td><?= Utils::h($confirm['manufact_name']); ?></td>
            <input type="hidden" name="manufact_name" value="<?= Utils::h($confirm['manufact_name']); ?>">
          </tr>
          <tr>
            <td>型番</td><td><?= Utils::h($confirm['model_name']); ?></td>
            <input type="hidden" name="model_name" value="<?= Utils::h($confirm['model_name']); ?>">
          </tr>
          <tr>
            <td>カテゴリー</td><td><?= Utils::h($confirm['category']); ?></td>
            <input type="hidden" name="category" value="<?= Utils::h($confirm['category']); ?>">
          </tr>
          <tr>
            <td>サイズ</td><td><?= Utils::h($confirm['size']); ?></td>
            <input type="hidden" name="size" value="<?= Utils::h($confirm['size']); ?>">
          </tr>
          <tr>
            <td>価格</td><td>￥<?= Utils::h(number_format($confirm['price'])); ?></td>
            <input type="hidden" name="price" value="<?= Utils::h($confirm['price']); ?>">
          </tr>
          <tr>
            <td>発注先</td><td><?= Utils::h($confirm['supplier']); ?></td>
            <input type="hidden" name="supplier" value="<?= Utils::h($confirm['supplier']); ?>">
          </tr>
          <tr>
            <td>注文コード</td><td><?= Utils::h($confirm['code']); ?></td>
            <input type="hidden" name="code" value="<?= Utils::h($confirm['code']); ?>">
          </tr>
          <tr>
            <td>電話番号</td><td><?= Utils::h($confirm['phone']); ?></td>
            <input type="hidden" name="phone" value="<?= Utils::h($confirm['phone']); ?>">
          </tr>
          <tr>
            <td>画像</td><td><div class="w-auto"><?= $showimg; ?></div></td>
            <input type="hidden" name="image_name" value="<?= Utils::h($confirm['image_name']); ?>">
          </tr>
        </table>
        <input type="hidden" name="register" value="1">
        <input type="hidden" name="csrf_token" value="<?= Utils::h($_SESSION["csrf_token"]); ?>">
        <div class="d-grid gap-2">
          <button class="btn btn-primary btn-success btn-lg rounded-pill mb-5" type="submit">登録</button>
        </div>
      </form>

      <?php if (empty($checked_err)) : ?>
      <form action="register_form.php" method="post">
        <div class="container text-center">
          <div class="d-flex flex-row-reverse">
            <button class="btn btn-primary rounded-pill" type="submit">戻る</button>
          </div>
        </div>
      </form>
      <?php else : ?>
      <form action="mypage.php" method="get">
        <div class="container text-center">
          <div class="d-flex flex-row-reverse">
            <button class="btn btn-primary rounded-pill">マイページ</button>
          </div>
        </div>
      </form>
      <?php endif; ?>
    </div>

<?php
  include('_footer.php');
