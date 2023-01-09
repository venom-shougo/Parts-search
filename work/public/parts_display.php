<?php

require_once(__DIR__ . '/../app/config.php');

Token::setToken();

//検索したパーツを取得
$get_parts = PartsLogic::getParts();

if (!empty($get_parts)) {
  //注文処理にセッションに保存
  $_SESSION['get_parts'] = $get_parts;
} else {
  header('Location: mypage.php');
  exit();
}

//注文バリデーションエラー
if (isset($_SESSION['order_err'])) {
  $order_err = $_SESSION['order_err'];
  unset($_SESSION['order_err']);
}

//セレクター初期値入力分岐
switch ($get_parts['category']) {
  case 'バルブ':
    $value1 = 'selected';
    break;
  case '配管':
    $value2 = 'selected';
    break;
  case '計器':
    $value3 = 'selected';
    break;
  case 'エアツール':
    $value4 = 'selected';
    break;
  case 'キャスター':
    $value5 = 'selected';
    break;
  case '掃除用具':
    $value6 = 'selected';
    break;
  case '表示類':
    $value7 = 'selected';
    break;
}

//編集バリーデーションエラー
$show = false;
if (isset($_SESSION['edit_err'])) {
  $edit_err = $_SESSION['edit_err'];
  $show = 'show';
  unset($_SESSION['edit_err']);
}

//管理者パスワードエラー
if (isset($_SESSION['admin_pass_err'])) {
  $admin_err = $_SESSION['admin_pass_err'];
  unset($_SESSION['admin_pass_err']);
}

include('_header.php');

?>

<div class="container">
  <h3 class="title-center mt-5 mb-3">部品詳細ページ</h3>
  <?php if ($admin === true) : ?>
    <p class="d-flex flex-row-reverse me-4 mb-2"><a class="btn btn-primary rounded-pill" data-bs-toggle="collapse" href="#collapseContent01" role="button" aria-expanded="false" aria-controls="collapseContent01">編集</a></p>
  <?php endif; ?>
  <table class="table table-striped">

    <form action="edit.php" method="post">
      <tr>
        <td class="td-color fs-5 fw-bold col-2">部品名</td>
        <td class="align-middle"><?= Utils::h($get_parts['partname']); ?></td>
        <td>
          <div class="collapse <?php if (!empty($show)) {echo Utils::h($show);} ?> form-floating-2 mb-3" id="collapseContent01">
            <input class="form-control mb-1" type="text" name="part_name" id="floatingInput" placeholder="部品名" value="<?= Utils::h($get_parts['partname']); ?>">
            <label for="floatingInput">部品名</label>
            <?php if (isset($edit_err['parts_err'])) : ?>
              <div role="alert">
                <h5><span class="badge bg-danger text-light"><i class="icon bi bi-exclamation-circle"></i> <?= Utils::h($edit_err['parts_err']); ?></span></h5>
              </div>
            <?php endif; ?>
          </div>
        </td>
      </tr>
      <tr>
        <td class="td-color fs-5 fw-bold col-2">メーカー</td>
        <td class="align-middle"><?= Utils::h($get_parts['manufacturer']); ?></td>
        <td>
          <div class="collapse <?php if (!empty($show)) {echo Utils::h($show);} ?> form-floating-2 mb-3" id="collapseContent01">
            <input class="form-control mb-1" type="text" name="manufact_name" id="floatingInput" placeholder="メーカー" value="<?= Utils::h($get_parts['manufacturer']); ?>">
            <label for="floatingInput">メーカー</label>
            <?php if (isset($edit_err['manufact_err'])) : ?>
              <div role="alert">
                <h5><span class="badge bg-danger text-light"><i class="icon bi bi-exclamation-circle"></i> <?= Utils::h($edit_err['manufact_err']); ?></span></h5>
              </div>
            <?php endif; ?>
          </div>
        </td>
      </tr>
      <tr>
        <td class="td-color fs-5 fw-bold col-2">型番</td>
        <td class="align-middle"><?= Utils::h($get_parts['model']); ?></td>
        <td>
          <div class="collapse <?php if (!empty($show)) {echo Utils::h($show);} ?> form-floating-2 mb-3" id="collapseContent01">
            <input class="form-control mb-1" type="text" name="model_name" id="floatingInput" placeholder="型番" value="<?= Utils::h($get_parts['model']); ?>">
            <label for="floatingInput">型番</label>
            <?php if (isset($edit_err['model_err'])) : ?>
              <div role="alert">
                <h5><span class="badge bg-danger text-light"><i class="icon bi bi-exclamation-circle"></i> <?= Utils::h($edit_err['model_err']); ?></span></h5>
              </div>
            <?php endif; ?>
          </div>
        </td>
      </tr>
      <tr>
        <td class="td-color fs-5 fw-bold col-2">カテゴリー</td>
        <td class="align-middle"><?= Utils::h($get_parts['category']); ?></td>
        <td>
          <div class="collapse <?php if (!empty($show)) {echo Utils::h($show);} ?> form-floating mb-3" id="collapseContent01">
            <select class="form-select mb-1" name="category" id="floatingCelect" placeholder="カテゴリー">
              <option value="0">選択してください</option>
              <option value="バルブ" <?= Utils::h($value1); ?>>バルブ</option>
              <option value="配管" <?= Utils::h($value2); ?>>配管</option>
              <option value="計器" <?= Utils::h($value3); ?>>計器</option>
              <option value="エアツール" <?= Utils::h($value4); ?>>エアツール</option>
              <option value="キャスター" <?= Utils::h($value5); ?>>キャスター</option>
              <option value="掃除用具" <?= Utils::h($value6); ?>>掃除用具</option>
              <option value="表示類" <?= Utils::h($value7); ?>>表示類</option>
            </select>
            <label for="floatingInput">カテゴリー</label>
            <?php if (isset($edit_err['category_err'])) : ?>
              <div role="alert">
                <h5><span class="badge bg-danger text-light"><i class="icon bi bi-exclamation-circle"></i> <?= Utils::h($edit_err['category_err']); ?></span></h5>
              </div>
            <?php endif; ?>
          </div>
        </td>
      </tr>
      <tr>
        <td class="td-color fs-5 fw-bold col-2">サイズ</td>
        <td class="align-middle"><?= Utils::h($get_parts['size']); ?></td>
        <td>
          <div class="collapse <?php if (!empty($show)) {echo Utils::h($show);} ?> form-floating-2 mb-3" id="collapseContent01">
            <input class="form-control mb-1" type="text" name="size" id="floatingInput" placeholder="サイズ" value="<?= Utils::h($get_parts['size']); ?>">
            <label for="floatingInput">サイズ</label>
            <?php if (isset($edit_err['size_err'])) : ?>
              <div role="alert">
                <h5><span class="badge bg-danger text-light"><i class="icon bi bi-exclamation-circle"></i> <?= Utils::h($edit_err['size_err']); ?></span></h5>
              </div>
            <?php endif; ?>
          </div>
        </td>
      </tr>
      <tr>
        <td class="td-color fs-5 fw-bold col-2">価格</td>
        <td class="align-middle">￥<?= Utils::h(number_format($get_parts['price'])); ?></td>
        <td>
          <div class="collapse <?php if (!empty($show)) {echo Utils::h($show);} ?> form-floating-2 mb-3" id="collapseContent01">
            <input class="form-control mb-1" type="text" name="price" id="floatingInput" placeholder="値段" value="<?= Utils::h($get_parts['price']); ?>">
            <label for="floatingInput">値段</label>
            <?php if (isset($edit_err['price_err'])) : ?>
              <div role="alert">
                <h5><span class="badge bg-danger text-light"><i class="icon bi bi-exclamation-circle"></i> <?= Utils::h($edit_err['price_err']); ?></span></h5>
              </div>
            <?php endif; ?>
          </div>
        </td>
      </tr>
      <tr>
        <td class="td-color fs-5 fw-bold col-2">発注先</td>
        <td class="align-middle"><?= Utils::h($get_parts['supplier']); ?></td>
        <td>
          <div class="collapse <?php if (!empty($show)) {echo Utils::h($show);} ?> form-floating-2 mb-3" id="collapseContent01">
            <input class="form-control mb-1" type="text" name="supplier" id="floatingInput" placeholder="発注先" value="<?= Utils::h($get_parts['supplier']); ?>">
            <label for="floatingInput">発注先</label>
            <?php if (isset($edit_err['supplier_err'])) : ?>
              <div role="alert">
                <h5><span class="badge bg-danger text-light"><i class="icon bi bi-exclamation-circle"></i> <?= Utils::h($edit_err['supplier_err']); ?></span></h5>
              </div>
            <?php endif; ?>
          </div>
        </td>
      </tr>
      <tr>
        <?php if (!empty($get_parts['code'])) : ?>
          <td class="td-color fs-5 fw-bold col-2">注文コード</td>
          <td class="align-middle"><?= Utils::h($get_parts['code']); ?></td>
        <?php else : ?>
          <td class="td-color fs-5 fw-bold col-2">注文コード</td>
          <td class="align-middle">－－</td>
        <?php endif; ?>
        <td>
          <div class="collapse <?php if (!empty($show)) {echo Utils::h($show);} ?> form-floating-2 mb-3" id="collapseContent01">
            <input class="form-control mb-1" type="text" name="code" id="floatingInput" placeholder="モノタロウは注文コード入力" value="<?= Utils::h($get_parts['code']); ?>">
            <label for="floatingInput">モノタロウは注文コード入力</label>
            <?php if (isset($edit_err['code_err'])) : ?>
              <div role="alert">
                <h5><span class="badge bg-danger text-light"><i class="icon bi bi-exclamation-circle"></i> <?= Utils::h($edit_err['code_err']); ?></span></h5>
              </div>
            <?php endif; ?>
          </div>
        </td>
      </tr>
      <tr>
        <?php if (!empty($get_parts['phone'])) : ?>
          <td class="td-color fs-5 fw-bold col-2">連絡先</td>
          <td class="align-middle"><?= Utils::h($get_parts['phone']); ?></td>
        <?php else : ?>
          <td class="td-color fs-5 fw-bold col-2">連絡先</td>
          <td class="align-middle">－－</td>
        <?php endif; ?>
        <td>
          <div class="collapse <?php if (!empty($show)) {echo Utils::h($show);} ?> form-floating-2 mb-3" id="collapseContent01">
            <input class="form-control mb-1" type="tel" name="phone" id="floatingInput" placeholder="発注先電話番号" value="<?= Utils::h($get_parts['phone']); ?>">
            <label for="floatingInput">発注先電話番号</label>
            <?php if (isset($edit_err['phone_err'])) : ?>
              <div role="alert">
                <h5><span class="badge bg-danger text-light"><i class="icon bi bi-exclamation-circle"></i> <?= Utils::h($edit_err['phone_err']); ?></span></h5>
              </div>
            <?php endif; ?>
          </div>

          <input type="hidden" name="id" value="<?= Utils::h($get_parts['id']); ?>">
          <input type="hidden" name="img" value="<?= Utils::h($get_parts['img_path']); ?>">
          <input type="hidden" name="csrf_token" value="<?= Utils::h($_SESSION["csrf_token"]); ?>">

          <div class="collapse <?php if (!empty($show)) {echo Utils::h($show);} ?> container text-center" id="collapseContent01">
            <div class="d-flex flex-row-reverse">
              <button class="btn btn-success rounded-pill" type="submit">登録</button>
            </div>
          </div>

        </td>
      </tr>
    </form>

    <tr>
      <td class="td-color fs-5 fw-bold col-2">画像</td>
      <td><img src="<?= $get_parts['img_path']; ?>" class="img-thumbnail"></td>
    </tr>
  </table>

  <form action="order.php" method="post">

    <div class="form-floating-2 mb-3" id="collapseContent01">
      <input class="form-control mb-1" type="text" name="num_ord" id="floatingInput" placeholder="発注数">
      <label for="floatingInput"> 発注数</label>
      <?php if (isset($order_err['num_err'])) : ?>
        <div role="alert">
          <h5><span class="badge bg-danger text-light"><i class="icon bi bi-exclamation-circle"></i> <?= Utils::h($order_err['num_err']); ?></span></h5>
        </div>
      <?php endif; ?>
    </div>

    <div class="form-check form-check-inline mt-1">
      <input class="form-check-input mb-1" type="checkbox" name="judge" id="check1" value="物品修理">
      <label class="form-check-rabel" for="check1">物品修理</label>
    </div>
    <div class="form-check form-check-inline">
      <input class="form-check-input mb-1" type="checkbox" name="judge" id="check2" value="物品購入">
      <label class="form-check-rabel" for="check2">物品購入</label>
    </div>
    <?php if (isset($order_err['judge_err'])) : ?>
      <div role="alert">
        <h5><span class="badge bg-danger text-light"><i class="icon bi bi-exclamation-circle"></i> <?= Utils::h($order_err['judge_err']); ?></span></h5>
      </div>
    <?php endif; ?>

    <div class="form-floating-2 mt-3">
      <textarea class="form-control mb-1" name="remarks" id="floatingTextarea" style="height: 100px;" placeholder="購入目的または請求理由"></textarea>
      <label for="floatingTextarea"> 購入目的または請求理由</label>
    </div>
    <?php if (isset($order_err['remarks_err'])) : ?>
      <div role="alert">
        <h5><span class="badge bg-danger text-light"><i class="icon bi bi-exclamation-circle"></i> <?= Utils::h($order_err['remarks_err']); ?></span></h5>
      </div>
    <?php endif; ?>

    <input type="hidden" name="csrf_token" value="<?= Utils::h($_SESSION["csrf_token"]); ?>">

    <div class="d-grid gap-2 mt-3">
      <button class="btn btn-success btn-lg mb-5 rounded-pill" type="submit">注文</button>
    </div>
  </form>

  <?php if ($admin === true) : ?>
    <form action="delete_parts.php" method="post">
      <label class="form-rabel" for="admin_pass"> 部品削除</label>
      <input class="form-control" type="password" name="admin_pass" id="admin_pass" placeholder="管理者パスワード">
      <input type="hidden" name="delete" value="<?= Utils::h($get_parts['id']); ?>">
      <?php if (isset($admin_err['admin_err'])) : ?>
        <div role="alert">
          <span><?= Utils::h($admin_err['admin_err']); ?></span>
        </div>
      <?php endif; ?>

      <input type="hidden" name="csrf_token" value="<?= Utils::h($_SESSION["csrf_token"]); ?>">

      <div class="d-grid gap-2 mt-3">
        <button class="btn btn-outline-danger btn-lg mb-5" type="submit">削除</button>
      </div>
    </form>
  <?php endif; ?>

  <div class="container text-center">
    <div class="d-flex flex-row-reverse">
      <a href="get_parts.php"><button class="btn btn-primary rounded-pill">戻る</button></a>
    </div>
  </div>

</div>

<?php
include('_footer.php');
