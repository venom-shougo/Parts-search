<?php

require_once(__DIR__ . '/../app/config.php');

$err = [];

// $values = $_SESSION['register'];

//未入力エラー
if (!empty($_SESSION['err'])) {
  $err = $_SESSION['err'];
  unset($_SESSION['err']);
}

//画像登録エラー
if (!empty($_SESSION['imgdir_err'])) {
  $err2 = $_SESSION['imgdir_err'];
}

if (isset($_SESSION['register'])) {
  unset($_SESSION['register']);
}

include('_header.php');

?>

<div class="container">
  <form action="register.php" method="post" enctype="multipart/form-data">

    <div class="form-floating-2 mb-3">
      <input class="form-control mb-1" type="text" name="parts_name" id="floatingInput" placeholder="部品名・サイズ">
      <label for="floatingInput">部品名・サイズ</label>
      <?php if (isset($err['parts_err'])) : ?>
        <div role="alert">
          <h5><span class="badge bg-danger text-light"><i class="icon bi bi-exclamation-circle"></i> <?= Utils::h($err['parts_err']); ?></span></h5>
        </div>
      <?php endif; ?>
    </div>

    <div class="form-floating-2 mb-3">
      <input class="form-control mb-1" type="text" name="model_name" id="floatingInput" placeholder="型番">
      <label for="floatingInput">型番</label>
      <?php if (isset($err['model_err'])) : ?>
        <div role="alert">
          <h5><span class="badge bg-danger text-light"><i class="icon bi bi-exclamation-circle"></i> <?= Utils::h($err['model_err']); ?></span></h5>
        </div>
      <?php endif; ?>
    </div>

    <div class="form-floating-2 mb-3">
      <input class="form-control mb-1" type="text" name="manufact_name" id="floatingInput" placeholder="メーカー">
      <label for="floatingInput">メーカー</label>
      <?php if (isset($err['manufact_err'])) : ?>
        <div role="alert">
          <h5><span class="badge bg-danger text-light"><i class="icon bi bi-exclamation-circle"></i> <?= Utils::h($err['manufact_err']); ?></span></h5>
        </div>
      <?php endif; ?>
    </div>

    <div class="form-floating mb-3">
      <select class="form-select mb-1" name="category" id="floatingCelect" placeholder="カテゴリー">
        <option value="0">選択してください</option>
        <option value="バルブ">バルブ</option>
        <option value="配管">配管</option>
        <option value="計器">計器</option>
        <option value="エアツール">エアツール</option>
        <option value="キャスター">キャスター</option>
        <option value="掃除用具">掃除用具</option>
        <option value="表示類">表示類</option>
      </select>
      <label for="floatingInput">カテゴリー</label>
      <?php if (isset($err['category_err'])) : ?>
        <div role="alert">
          <h5><span class="badge bg-danger text-light"><i class="icon bi bi-exclamation-circle"></i> <?= Utils::h($err['category_err']); ?></span></h5>
        </div>
      <?php endif; ?>
    </div>

    <div class="form-floating-2 mb-3">
      <input class="form-control mb-1" type="text" name="size" id="floatingInput" placeholder="サイズ">
      <label for="floatingInput">サイズ</label>
      <?php if (isset($err['size_err'])) : ?>
        <div role="alert">
          <h5><span class="badge bg-danger text-light"><i class="icon bi bi-exclamation-circle"></i> <?= Utils::h($err['size_err']); ?></span></h5>
        </div>
      <?php endif; ?>
    </div>

    <div class="form-floating-2 mb-3">
      <input class="form-control mb-1" type="text" name="price" id="floatingInput" placeholder="値段">
      <label for="floatingInput">値段</label>
      <?php if (isset($err['price_err'])) : ?>
        <div role="alert">
          <h5><span class="badge bg-danger text-light"><i class="icon bi bi-exclamation-circle"></i> <?= Utils::h($err['price_err']); ?></span></h5>
        </div>
      <?php endif; ?>
    </div>

    <div class="form-floating-2 mb-3">
      <input class="form-control mb-1" type="text" name="supplier" id="floatingInput" placeholder="発注先">
      <label for="floatingInput">発注先</label>
      <?php if (isset($err['supplier_err'])) : ?>
        <div role="alert">
          <h5><span class="badge bg-danger text-light"><i class="icon bi bi-exclamation-circle"></i> <?= Utils::h($err['supplier_err']); ?></span></h5>
        </div>
      <?php endif; ?>
    </div>

    <div class="form-floating-2 mb-3">
      <input class="form-control mb-1" type="text" name="code" id="floatingInput" placeholder="注文コード">
      <label for="floatingInput">注文コード</label>
      <?php if (isset($err['code_err'])) : ?>
        <div role="alert">
          <h5><span class="badge bg-danger text-light"><i class="icon bi bi-exclamation-circle"></i> <?= Utils::h($err['code_err']); ?></span></h5>
        </div>
      <?php endif; ?>
    </div>

    <div class="form-floating-2 mb-3">
      <input class="form-control mb-1" type="tel" name="phone" id="floatingInput" placeholder="発注先電話番号">
      <label for="floatingInput">発注先電話番号</label>
      <?php if (isset($err['phone_err'])) : ?>
        <div role="alert">
          <h5><span class="badge bg-danger text-light"><i class="icon bi bi-exclamation-circle"></i> <?= Utils::h($err['phone_err']); ?></span></h5>
        </div>
      <?php endif; ?>
    </div>

    <div class="mb-3">
      <!-- <span class="badge bg-danger text-light" for="floatingInput" id="image">画像選択</span> -->
      <input class="form-control mb-1" type="file" accep="image/*" name="image" aria-describedby="image">
      <?php if (isset($err['img_err'])) : ?>
        <div role="alert">
          <h5><span class="badge bg-danger text-light"><i class="icon bi bi-exclamation-circle"></i> <?= Utils::h($err['img_err']); ?></span></h5>
        </div>
      <?php endif; ?>
      <?php if (isset($err2)) : ?>
        <div role="alert">
          <h5><span class="badge bg-danger text-light"><i class="icon bi bi-exclamation-circle"></i> <?= Utils::h($err2); ?></span></h5>
        </div>
      <?php endif; ?>
    </div>

    <div class="form-floating-2 mb-3">
      <input class="form-control mb-1" type="text" name="image_name" id="floatingInput" placeholder="画像名">
      <label for="floatingInput">画像名</label>
      <?php if (isset($err['imgname_err'])) : ?>
        <div role="alert">
          <h5><span class="badge bg-danger text-light"><i class="icon bi bi-exclamation-circle"></i> <?= Utils::h($err['imgname_err']); ?></span></h5>
        </div>
      <?php endif; ?>
    </div>

    <div class="d-grid gap-2">
      <button class="btn btn-primary btn-success btn-lg rounded-pill mb-5" type="submit">確認</button>
    </div>

  </form>
  <form action="mypage.php" method="get">
    <div class="container text-center">
      <div class="d-flex flex-row-reverse">
        <button class="btn btn-primary rounded-pill">マイページ</button>
      </div>
    </div>
  </form>
</div>

<?php
include('_footer.php');
