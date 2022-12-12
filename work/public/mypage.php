<?php

require_once(__DIR__ . '/../app/config.php');

// phpinfo();

//パーツ検索セッションリセット
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  unset($_SESSION['confirm']);
  unset($_SESSION['registimage']);
  unset($_SESSION['register']);
  unset($_SESSION['checked_err']);
  unset($_SESSION['get_parts']);
  unset($_SESSION['excel_msg']);
  unset($_SESSION['history']);
  unset($_SESSION['order_parts']);
  unset($_SESSION['history_parts']);
  unset($_SESSION['history_err']);
  unset($_SESSION['detail_parts']);
  unset($_SESSION['admin_pass_err']);
  unset($_SESSION['send_parts']);
  unset($_SESSION['search_err']);
  unset($_SESSION['csrf_token']);
  unset($_SESSION['count']);
}
// unset($_SESSION['send_parts']);
// unset($_SESSION['err']);
// unset($_SESSION['bool']);




// ログイン中合否判定、丕は新規画面へ
$result = UserLogic::checkLogin();
if (!$result) {
  $_SESSION['login_err'] = '社員番号を登録してログインしてください';
  header('Location: login_form.php');
  return;
}

// adminユーザチェック
if ($admin === true) {
  // MySql操作
  $db = Db::searchTables();
}

//パーツ検索バリデーション結果の表示処理
if (isset($_SESSION['validation_err'])) {
  $validation_srr = $_SESSION['validation_err'];
  unset($_SESSION['validation_err']);
}



//パーツ検索Formをセッションに保存
//
//POST処理分岐
if (isset($_POST['search'])) {
  $_SESSION['send_parts'] = $_POST;
  header('Location: get_parts.php?page=1');
  exit();
} elseif (isset($_POST['db'])) {
  $column = $_POST;
  $get_column = Db::getColumn($column);
  // var_dump($get_column);
} else {
  $edit_column = $_POST;
  // var_dump($edit_column);
  // exit;
}

include('_header.php');

?>

<div class="container">

  <form action="" method="post">

    <table class="table mb-1">
      <tr>
        <td><label class="form-label fs-5" for="search1">検索方法</label></td>
        <td><select class="form-select mb-1" name="search" id="search1">
            <option value="0">選択してください</option>
            <option value="1">メーカー名</option>
            <option value="2">部品名</option>
            <option value="3">カテゴリ名</option>
            <option value="4">サイズ</option>
          </select>
          <?php if (isset($validation_srr['category_err'])) : ?>
            <div role="alert">
              <h5><span class="text-size badge bg-danger text-light"><i class="icon bi bi-exclamation-circle"></i> <?= Utils::h($validation_srr['category_err']); ?></span></h5>
            </div>
          <?php endif; ?>
        </td>
      </tr>
      <tr>
        <td><label class="form-label fs-5" for="search_name1">検索名入力</label></td>
        <td>
          <input class="form-control mb-1" type="text" name="search_name" id="search_name1">
          <?php if (isset($validation_srr['search_name_err'])) : ?>
            <div role="alert">
              <h5><span class="badge bg-danger text-light"><i class="icon bi bi-exclamation-circle"></i> <?= Utils::h($validation_srr['search_name_err']); ?></span></h5>
            </div>
          <?php endif; ?>
        </td>
      </tr>
    </table>
    <div class="d-grid gap-2 mt-3">
      <button class="btn btn-primary btn-lg mb-5 rounded-pill" type="submit">検索</button>
    </div>
  </form>

  <?php if ($admin === true) : ?>

    <p class="h3 text-center mb-5">データベース操作</p>

    <?php if (empty($column)) : ?>

      <p class="h4 mb-2 text-center">テーブル一覧</p>
      <div class="w-75 m-auto">
        <form action="" method="post">
          <table class="table">
            <tr>
              <th class="col-3">テーブルID</th>
              <th>テーブル名</th>
            </tr>
            <?php if (isset($db)) : ?>
              <?php foreach ($db as $key => $disp) : ?>
                <tr>
                  <td><?= Utils::h($key); ?></td>
                  <td>
                    <button class="but btn-link ms-4" type="submit" name="db" value="<?= Utils::h($disp['Tables_in_myapp']); ?>"><?= Utils::h($disp['Tables_in_myapp']); ?></button>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </table>
        </form>
      </div>
    <?php else : ?>
      <p class="h4 mb-2 text-center">テーブル詳細</p>
      <section class="mb-5">
        <form action="" method="post">

          <table class="table table-bordered border shadow">
            <thead class="table-light">
              <tr class="table-primary">
                <th class="col-2">Field</th>
                <th class="col-2">Type</th>
                <th class="col-1">Null</th>
                <th class="col-1">Key</th>
                <th class="col-3">Default</th>
                <th class="col-3">Extra</th>
              </tr>
            </thead>

            <?php if (isset($get_column)) : ?>
              <?php $count = (COUNT($get_column));
              for ($i = 0; $i <= $count; $i++) : ?>
                <?php $id = $get_column[$i]; ?>
                <tr>
                  <?php foreach ($id as $key => $d) : ?>
                    <td><?= Utils::h($d); ?><p class="d-flex flex-row-reverse me-4 mb-2"><a class="btn dropdown-toggle" data-bs-toggle="collapse" href="#collapseContent<?= Utils::h(0 . $i); ?>" role="button" aria-expanded="false" aria-controls="collapseContent<?= Utils::h(0 . $i); ?>"></a></p>
                      <div class="collapse mb-3" id="collapseContent<?= Utils::h(0 . $i); ?>">
                        <input class="form-control mb-1" type="text" name="column<?= Utils::h($i) . '_' . Utils::h($key); ?>" id="" value="<?= Utils::h($d); ?>">
                      </div>
                    </td>
                  <?php endforeach; ?>
                </tr>
              <?php endfor; ?>
            <?php endif; ?>
          </table>
          <button class="btn btn-primary" type="submit">編集</button>
        </form>
      </section>
      <div class="d-flex flex-row-reverse">
        <a href="mypage.php"><button class="btn btn-primary rounded-pill">戻る</button></a>
      </div>
    <?php endif; ?>
  <?php endif; ?>
</div>
<?php
include('_footer.php');
