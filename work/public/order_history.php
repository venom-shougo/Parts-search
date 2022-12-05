<?php
require_once(__DIR__ . '/../app/config.php');

Token::setToken();

if (!empty($_SESSION['history_parts'])) {
  $history_parts = $_SESSION['history_parts']; //注文数詳細を代入
  // var_dump($history_parts);
  // exit;
  $get_history = OrderLogic::detailHistory($history_parts); //内部結合で購入履歴と部品を取得
  $_SESSION['get_parts'] = $get_history; //orderParts処理の値を保存
  $result_img = ImageAcqu::getImage($get_history); //部品詳細から画像を取得
  $_SESSION['history_img'] = $result_img; //注文処理後の画像表示
}


//再注文バリデーションエラー
if (isset($_SESSION['order_err'])) {
  $order_err = $_SESSION['order_err'];
  unset($_SESSION['order_err']);
}

include('_header.php');

?>

  <div class="container">
    <h3 class="title-center mt-5 mb-3">購入履歴結果</h3>

    <table class="table table-striped">
      <tr>
        <td class="td-color fs-5 fw-bold col-3">発注日</td><td class="align-middle"><?= Utils::h($get_history['date']); ?></td>
      </tr>
      <tr>
        <td class="td-color fs-5 fw-bold col-3">部品名</td><td class="align-middle"><?= Utils::h($get_history['partname']); ?></td>
      </tr>
      <tr>
        <td class="td-color fs-5 fw-bold col-3">型番</td><td class="align-middle"><?= Utils::h($get_history['model']); ?></td>
      </tr>
      <tr>
        <td class="td-color fs-5 fw-bold col-3">メーカー</td><td class="align-middle"><?= Utils::h($get_history['manufacturer']); ?></td>
      </tr>
      <tr>
        <td class="td-color fs-5 fw-bold col-3">カテゴリ</td><td class="align-middle"><?= Utils::h($get_history['category']); ?></td>
      </tr>
      <tr>
        <td class="td-color fs-5 fw-bold col-3">サイズ</td><td class="align-middle"><?= Utils::h($get_history['size']); ?></td>
      </tr>
      <tr>
        <td class="td-color fs-5 fw-bold col-3">価格</td><td class="align-middle">￥<?= Utils::h(number_format($get_history['price'])); ?></td>
      </tr>
      <tr>
        <td class="td-color fs-5 fw-bold col-3">注文数</td><td class="align-middle"><?= Utils::h($get_history['order_num']); ?> ｹ</td>
      </tr>
      <tr>
        <td class="td-color fs-5 fw-bold col-3">金額合計</td><td class="align-middle">￥<?= Utils::h(number_format($get_history['order_price'])); ?></td>
      </tr>
      <tr>
        <td class="td-color fs-5 fw-bold col-3">発注先</td><td class="align-middle"><?= Utils::h($get_history['supplier']); ?></td>
      </tr>
      <tr>
        <?php if (!empty($get_history['code'])) : ?>
          <td class="td-color fs-5 fw-bold col-3">注文コード</td><td class="align-middle"><?= Utils::h($get_history['code']); ?></td>
        <?php else : ?>
          <td class="td-color fs-5 fw-bold col-3">注文コード</td><td class="align-middle">－－</td>
        <?php endif; ?>
        </tr>
        <tr>
          <?php if (!empty($get_history['phone'])) : ?>
            <td class="td-color fs-5 fw-bold col-3">連絡先</td><td class="align-middle"><?= Utils::h($get_history['phone']); ?></td>
          <?php else : ?>
            <td class="td-color fs-5 fw-bold col-3">連絡先</td><td class="align-middle">－－</td>
          <?php endif; ?>
        </tr>
      <tr>
        <td class="td-color fs-5 fw-bold col-3">購入目的または請求理由</td><td class="align-middle"><?= Utils::h($get_history['remarks']); ?></td>
      </tr>
      <tr>
        <td class="td-color fs-5 fw-bold col-3">画像</td><td><img src="<?= $result_img['img_path']; ?>"></td>
      </tr>
    </table>

    <form action="order.php" method="post">

      <div class="form-floating-2 mb-3">
        <input class="form-control mb-1" type="text" name="his_num_ord" id="floatingInput" placeholder="発注数">
        <label for="floatingInput"> 発注数</label>
          <?php if (isset($order_err['his_num_err'])) : ?>
            <div role="alert">
              <h5><span class="badge bg-danger text-light"><i class="icon bi bi-exclamation-circle"></i> <?= Utils::h($order_err['his_num_err']); ?></span></h5>
            </div>
          <?php endif; ?>
      </div>

      <div class="form-check form-check-inline mt-1">
        <input class="form-check-input" type="checkbox" name="his_judge" id="check1" value="物品修理">
        <label class="form-check-rabel" for="check1">物品修理</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" name="his_judge" id="check2" value="物品購入">
        <label class="form-check-rabel" for="check2">物品購入</label>
      </div>
        <?php if (isset($order_err['his_judge_err'])) : ?>
          <div role="alert">
            <h5><span class="badge bg-danger text-light"><i class="icon bi bi-exclamation-circle"></i> <?= Utils::h($order_err['his_judge_err']); ?></span></h5>
          </div>
        <?php endif; ?>

      <div class="form-floating-2 mt-3">
        <textarea class="form-control mb-1" name="his_remarks" id="floatingTextarea" style="height: 100px;" placeholder="購入目的または請求理由"></textarea>
        <label for="floatingTextarea"> 購入目的または請求理由</label>
      </div>
        <?php if (isset($order_err['his_remarks_err'])) : ?>
          <div role="alert">
            <h5><span class="badge bg-danger text-light"><i class="icon bi bi-exclamation-circle"></i> <?= Utils::h($order_err['his_remarks_err']); ?></span></h5>
          </div>
        <?php endif; ?>

        <input type="hidden" name="csrf_token" value="<?= Utils::h($_SESSION["csrf_token"]); ?>">

      <div class="d-grid gap-2 mt-3">
        <button class="btn btn-success btn-lg mb-5" type="submit">注文</button>
      </div>
    </form>
  </div>
    <div class="container text-center">
      <div class="d-flex flex-row-reverse">
        <a href="get_history.php"><button class="btn btn-primary rounded-pill">戻る</button></a>
      </div>
    </div>

<?php
  include('_footer.php');
