<?php
require_once(__DIR__ . '/../app/config.php');

/**
 * 購入履歴一覧表示処理
 */

if (isset($_SESSION['login_user']) && $_SESSION['login_user']['id'] >0) {
  $login_user = $_SESSION['login_user'];
}

//ページネーション用URL取得
if (!empty($_SERVER['SCRIPT_NAME'])) {
  $url = $_SERVER['SCRIPT_NAME'];
}

//購入履歴前件数取得
$history_count = OrderLogic::totalHistory($login_user);

//ページネーションクラス
$count = array_column($history_count, 'count'); //トータルデータ数
$per_page = TOTAL_RECORDS_PER_PAGE; //１ページあたりのデータ件数
$max_page = ceil($count[0] / $per_page); //最大ページ数

//GETで渡されたページを確認
if (!isset($_GET['page'])) {
  $now = 1;
} else {
  $now = $_GET['page'];
}

//ユーザの注文履歴テーブルから履歴取得
$order = OrderLogic::orderHistory($login_user, $now, $per_page);

//idは次のPOST処理のvalue値にする
//日付とパーツ名を value に変換 id を key にする処理
if (!empty($order)) {
  $num_data = count((array)$order); //データ数
  $id = array_column((array)$order, 'id'); //返値からidを抜き出す
  $date_parts = array_column((array)$order, 'order_part_name', 'date'); //日付をキーにしてパーツ名
  array_walk($date_parts,function(&$v,$k){
    $v = $k." - ".$v;
  });
  $com = array_values($date_parts);
  $history = array_combine($id, $com); //idをキーに、日付部品名をバリューに
} else {
  //検索結果が０件
  $history_err = $_SESSION['history_err'];
  $num_data = 0;
}

//全データ件数表示
$current = $now * $num_data;
$total_num = '全' . $count[0] . '件中 ' . $current .'件';

//検索結果から選ばれたパーツ formの値をセッションに保存
if (!empty($_POST)) {
  if(isset($_POST['id'])) {
    $_SESSION['history_parts'] = $_POST;
    header('Location: order_history.php');
    exit();
  } else {
    //検索詳細form値をセッションに保存
    $_SESSION['send_parts'] = $_POST;
    header('Location: search_history.php?page=1');
    exit();
  }
}

//パーツ検索バリデーション結果の表示処理
if (isset($_SESSION['validation_err'])) {
  $validation_srr = $_SESSION['validation_err'];
  $err_label = '詳細検索を確認';
  unset($_SESSION['validation_err']);
}


include('_header.php');

?>
  <div class="container">
    <?php if(!empty($history_err)) : ?>
      <h3 class="title-center">購入履歴</h3>
        <table class="table">
          <thead>
            <tr>
              <th class="col">No</th>
              <th class="col-2">注文日</th>
              <th class="col-8">品名</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><div class="h4 text-danger mt-4"><?= Utils::h($history_err); ?></div></td>
            </tr>
          </tbody>
        </table>
        <form action="mypage.php" method="get">
          <div class="container text-center">
            <div class="d-flex flex-row-reverse">
              <button class="btn btn-primary rounded-pill">マイページ</button>
            </div>
          </div>
        </form>
    <?php else : ?>
      <h3 class="title-center">注文履歴</h3>
      <div class="container">
        <div class="d-flex flex-row-reverse">
          <div class="dropdown text-end">
            <?php if (empty($err_label)) : ?>
              <a href="#" class="fs-5 d-block link-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">詳細検索</a>
            <?php else : ?>
              <a href="#" class="fs-5 d-block link-dark text-decoration-none dropdown-toggle alert alert-danger text-center rounded" data-bs-toggle="dropdown" aria-expanded="false"><?= Utils::h($err_label); ?></a>
            <?php endif; ?>
            <ul class="dropdown-menu text-small">
              <li>
                <form action="" method="post">
                  <label class="form-label fs-6" for="search1">検索方法</label>
                    <select class="form-select" name="search" id="search1">
                      <option value="0">選択してください</option>
                      <option value="1">メーカー名</option>
                      <option value="2">部品名</option>
                      <option value="3">カテゴリ名</option>
                      <option value="4">サイズ</option>
                    </select>
                    <?php if (isset($validation_srr['category_err'])) : ?>
                      <div class="alert alert-danger rounded" role="alert">
                        <span><?= Utils::h($validation_srr['category_err']); ?></span>
                      </div>
                    <?php endif; ?>
                  <label class="form-label fs-6 mt-2" for="search_name1">検索名入力</label>
                  <input class="form-control" type="text" name="search_name" id="search_name1">
                  <?php if (isset($validation_srr['search_name_err'])) : ?>
                    <div class="alert alert-danger rounded" role="alert">
                      <span><?= Utils::h($validation_srr['search_name_err']); ?></span>
                    </div>
                  <?php endif; ?>
                  <div  class="container">
                    <div class="d-flex flex-row-reverse">
                      <button class="btn btn-success rounded-pill mt-2" type="submit">検索</button>
                    </div>
                  </div>
                </form>
              </li>
            </ul>
          </div>
        </div>
      </div>
        <table class="table-2">
          <thead>
            <tr>
              <th class="col-1"></th>
              <th class="col-1">No</th>
              <th class="col-3">注文日</th>
              <th class="col-7">品名</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
        <div class="d-flex flex-column mx-auto p-1 w-75">
          <?php $i = 1; foreach ((array)$history as $key => $disp) : ?>
            <?php $disp = substr_replace($disp, '', 12,11); ?>
              <form action="" method="post">
                <ul class="list-unstyled parts-list">
                  <li class="lead ms-4"><?= $i .'.'; ?>
                  <button class="but btn-link ms-4"><?= Utils::h($disp); ?></button>
                  <input type="hidden" name="id" value="<?= Utils::h($key); ?>"></li>
                </ul>
              </form>
          <?php $i++; endforeach; ?>
        </div>
      <div class="text-center mt-3 mb-2">
        <p><?= Utils::h($total_num) ?></p>
      </div>
      <nav>
        <ul class="pagination justify-content-center">
          <?= Utils::h(Paging::paging($max_page, $now, 2, $url)); ?>
        </ul>
      </nav>

      <form action="mypage2.php" method="get">
        <div class="container text-center">
          <div class="d-flex flex-row-reverse">
            <button class="btn btn-primary rounded-pill mt-3">マイページ</button>
          </div>
        </div>
      </form>
    <?php endif; ?>
  </div>

<?php
  include('_footer.php');
