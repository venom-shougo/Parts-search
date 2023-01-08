<?php

require_once(__DIR__ . '/../app/config.php');
// var_dump($_SESSION);
// トークン照会
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  Token::validateToken();
}
unset($_SESSION['csrf_token']);

//注文か削除かPOST判定
if (!empty($_POST)) {
  if (isset($_POST['num_ord'])) {
    //パーツ注文処理
    $_SESSION['order_parts'] = $_POST;
    $_SESSION['excel_msg'] = '請求伝票を作成しExcelを開いて印刷してください';
  } elseif (isset($_POST['his_num_ord'])) {
    $_SESSION['order_parts'] = $_POST;
    $_SESSION['excel_msg'] = '請求伝票を作成しExcelを開いて印刷してください';
  }
}

//注文バリデーション
$err = OrderValidation::setOrder();

if (empty($err)) {
  //再登録防止処理
  if (!isset($_SESSION['count'])) {
    $_SESSION['count'] = 1;
  } else {
    $count = $_SESSION['count'];
    $count ++;
    $_SESSION['count'] = $count;
  }
} else {
  $_SESSION['count'] = 0;
}

if ($_SESSION['count'] > 1) {
  header('Location: mypage.php');
  exit();
}

// エラー判定
if (count($err) > 0) {
  //パーツ検索から⬇︎
  if (isset($err['num_err'])) {
    $_SESSION['order_err'] = $err;
    header('Location: parts_display.php');
    return;
    //注文履歴から⬇︎
  } elseif (isset($err['his_num_err'])) {
    $_SESSION['order_err'] = $err;
    header('Location: order_history.php');
    return;
  }
} else {
  //エラー０件でorder_historyテーブルに注文内容を登録
  $order_parts = OrderLogic::orderParts();
}

//注文登録の成功分岐
if (isset($order_parts)) {
  //注文履歴詳細取得後Excel処理用セッション保存
  $order_history = OrderLogic::detailHistory($order_parts);
  $_SESSION['history'] = $order_history;

  //パーツ検索から注文または注文履歴から注文の分岐
  if (isset($_SESSION['history_img'])) {
    //$get_partsには注文パーツ表示処理、パーツ検索＆注文履歴の値が入る
    $get_parts = $_SESSION['get_parts'];
    $history_img = $_SESSION['history_img'];
    $get_parts = array_merge($get_parts, $history_img);
  } else {
    $get_parts = $_SESSION['get_parts'];
  }
} else {
  $excle_msg = '購入処理ができません';
}
//エクセル出力メッセージ
if (isset($_SESSION['excel_msg'])) {
  $excel_msg = $_SESSION['excel_msg'];
}

include('_header.php');

?>

  <div class="container">
    <?php if (!empty($excel_msg)) : ?>
      <div class="container">
        <div class="h4 alert alert-warning text-center rounded">
          <?= Utils::h($excel_msg); ?>
        </div>
      </div>
    <?php endif; ?>
    <form action="excel_out.php" method="get">
      <input type="hidden" name="excel">
      <div class="container">
        <button class="btn btn-success" type="submit">請求伝票作成</button>
      </div>
    </form>
    <table class="table table-striped mt-3">
      <tr>
        <td>部品名</td><td><?= Utils::h($get_parts['partname']); ?></td>
      </tr>
      <tr>
        <td>メーカー</td><td><?= Utils::h($get_parts['manufacturer']); ?></td>
      </tr>
      <tr>
        <td>型番</td><td><?= Utils::h($get_parts['model']); ?></td>
      </tr>
      <tr>
        <td>カテゴリー</td><td><?= Utils::h($get_parts['category']); ?></td>
      </tr>
      <tr>
        <td>サイズ</td><td><?= Utils::h($get_parts['size']); ?></td>
      </tr>
      <tr>
        <td>価格</td><td>￥<?= Utils::h(number_format($get_parts['price'])); ?></td>
      </tr>
      <tr>
        <td>発注先</td><td><?= Utils::h($get_parts['supplier']); ?></td>
      </tr>
      <tr>
        <td>注文コード</td><td><?= Utils::h($get_parts['code']); ?></td>
      </tr>
      <tr>
        <td>注文数</td><td><?= Utils::h($order_history['order_num']); ?>ｹ</td>
      </tr>
      <tr>
        <td>合計金額</td><td>￥<?= Utils::h(number_format($order_history['order_price'])); ?></td>
      </tr>
      <tr>
        <td>電話番号</td><td><?= Utils::h($get_parts['phone']); ?></td>
      </tr>
      <tr>
        <td>注文種別</td><td><?= Utils::h($order_history['judge']); ?></td>
      </tr>
      <tr>
        <td>請求理由</td><td><?= Utils::h($order_history['remarks']); ?></td>
      </tr>
      <tr>
        <td>画像</td><td><img src="<?= $get_parts['img_path']; ?>" class="img-thumbnail"></td>
      </tr>
    </table>
  </div>
  <div class="container text-center">
    <div class="d-flex flex-row-reverse">
      <form action="mypage2.php" method="get">
        <button class="btn btn-primary rounded-pill">マイページ</button>
      </form>
    </div>
  </div>

<?php
  include('_footer.php');
