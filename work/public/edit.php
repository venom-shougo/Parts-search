<?php

require_once(__DIR__ . '/../app/config.php');

Token::setToken();

//パーツフォーム編集入力後POST処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $edit_parts = $_POST;
  $get_parts = $_SESSION['get_parts'];
  $_SESSION['edit_parts'] = $edit_parts;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  //再登録防止処理
  if (!isset($_SESSION['count'])) {
    $_SESSION['count'] = 1;
  } else {
    $count = $_SESSION['count'];
    $count++;
    $_SESSION['count'] = $count;
  }
} elseif ($_POST['parts_name']) {
  $_SESSION['count'] = 1;
} else {
  $_SESSION['count'] = 0;
}


//画像登録エラーが無ければページカウンター判定
if (empty($_SESSION['edit_err'])) {
  if ($_SESSION['count'] > 1) {
    header('Location: mypage.php');
    exit();
  }
} else {
  unset($_SESSION['edit_err']);
}


//登録パーツバリデーション
$err = [];
$err = PartsValidateForm::editParts($edit_parts);

// エラーカウント
if (count($err) > 0) {
  $_SESSION['edit_err'] = $err;
  header('Location: parts_display.php');
  return;
}

//差分をCSSで表示
var_dump($edit_parts);
var_dump($get_parts);
$result = array_diff( $get_parts, $edit_parts);
var_dump($result);

//三項演算子でスタイルを適用
isset($result['partname']) ? $text_color1 = 'text-success h5' : false;
isset($result['manufacturer']) ? $text_color2 = 'text-success h5' : false;
isset($result['model']) ? $text_color3 = 'text-success h5' : false;
isset($result['category']) ? $text_color4 = 'text-success h5' : false;
isset($result['size']) ? $text_color5 = 'text-success h5' : false;
isset($result['price']) ? $text_color6 = 'text-success h5' : false;
isset($result['supplier']) ? $text_color7 = 'text-success h5' : false;
isset($result['code']) ? $text_color8 = 'text-success h5' : false;
isset($result['phone']) ? $text_color9 = 'text-success h5' : false;

include('_header.php');

?>

<main>
  <div class="container">
    <h1 class="h3 mb-3 fw-normal text-center">入力確認</h1>
    <p class="h5 alert alert-warning text-center rounded">入力に間違いがないかご確認ください</p>

    <form action="record.php" method="post">
      <table class="table table-striped">
        <tr>
          <th class="col-2"></th>
          <th class="col-3">変更後</th>
          <th class="col-3">変更前</th>
        </tr>
        <tr>
          <td>部品名</td>
          <td class="<?= Utils::h($text_color1); ?>"><?= Utils::h($edit_parts['parts_name']); ?></td>
          <td><?= Utils::h($get_parts['partname']); ?></td>
          <input type="hidden" name="parts_name" value="<?= Utils::h($edit_parts['parts_name']); ?>">
        </tr>
        <tr>
          <td>メーカー</td>
          <td class="<?= Utils::h($text_color2); ?>"><?= Utils::h($edit_parts['manufact_name']); ?></td>
          <td><?= Utils::h($get_parts['manufacturer']); ?></td>
          <input type="hidden" name="manufact_name" value="<?= Utils::h($edit_parts['manufact_name']); ?>">
        </tr>
        <tr>
          <td>型番</td>
          <td class="<?= Utils::h($text_color3); ?>"><?= Utils::h($edit_parts['model_name']); ?></td>
          <td><?= Utils::h($get_parts['model']); ?></td>
          <input type="hidden" name="model_name" value="<?= Utils::h($edit_parts['model_name']); ?>">
        </tr>
        <tr>
          <td>カテゴリー</td>
          <td class="<?= Utils::h($text_color4); ?>"><?= Utils::h($edit_parts['category']); ?></td>
          <td><?= Utils::h($get_parts['category']); ?></td>
          <input type="hidden" name="category" value="<?= Utils::h($edit_parts['category']); ?>">
        </tr>
        <tr>
          <td>サイズ</td>
          <td class="<?= Utils::h($text_color5); ?>"><?= Utils::h($edit_parts['size']); ?></td>
          <td><?= Utils::h($get_parts['size']); ?></td>
          <input type="hidden" name="size" value="<?= Utils::h($edit_parts['size']); ?>">
        </tr>
        <tr>
          <td>価格</td>
          <td class="<?= Utils::h($text_color6); ?>">￥<?= Utils::h(number_format($edit_parts['price'])); ?></td>
          <td>￥<?= Utils::h(number_format($get_parts['price'])); ?></td>
          <input type="hidden" name="price" value="<?= Utils::h($edit_parts['price']); ?>">
        </tr>
        <tr>
          <td>発注先</td>
          <td class="<?= Utils::h($text_color7); ?>"><?= Utils::h($edit_parts['supplier']); ?></td>
          <td><?= Utils::h($get_parts['supplier']); ?></td>
          <input type="hidden" name="supplier" value="<?= Utils::h($edit_parts['supplier']); ?>">
        </tr>
        <tr>
          <td>注文コード</td>
          <td class="<?= Utils::h($text_color8); ?>"><?= Utils::h($edit_parts['code']); ?></td>
          <td><?= Utils::h($get_parts['code']); ?></td>
          <input type="hidden" name="code" value="<?= Utils::h($edit_parts['code']); ?>">
        </tr>
        <tr>
          <td>電話番号</td>
          <td class="<?= Utils::h($text_color9); ?>"><?= Utils::h($edit_parts['phone']); ?></td>
          <td><?= Utils::h($get_parts['phone']); ?></td>
          <input type="hidden" name="phone" value="<?= Utils::h($edit_parts['phone']); ?>">
        </tr>
        <tr>
          <td>画像</td>
          <td>
            <div class="w-auto"><img src="<?= $edit_parts['img'] ?>" class="img-thumbnail"></div>
          </td>
        </tr>
      </table>
      <input type="hidden" name="edit" value="2">
      <input type="hidden" name="id" value="<?= Utils::h($edit_parts['id']); ?>">
      <input type="hidden" name="csrf_token" value="<?= Utils::h($_SESSION["csrf_token"]); ?>">
      <div class="d-grid gap-2">
        <button class="btn btn-primary btn-success btn-lg rounded-pill mb-5" type="submit">登録</button>
      </div>
    </form>

    <form action="parts_display.php" method="post">
      <div class="container text-center">
        <div class="d-flex flex-row-reverse">
          <button class="btn btn-primary rounded-pill" type="submit">戻る</button>
        </div>
      </div>
    </form>

  </div>

  <?php
  include('_footer.php');
