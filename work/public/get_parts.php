<?php

require_once(__DIR__ . '/../app/config.php');

/**
 * パーツ検索から画像リスト表示処理
 */

//ページネーション用URL取得
if (!empty($_SERVER['SCRIPT_NAME'])) {
  $url = $_SERVER['SCRIPT_NAME'];
}

// $referer = $_SERVER['HTTP_REFERER'];

//パーツ検索入力の検査
$err = [];
$err = PartsValidateForm::searchParts();
if (count($err) > NUMBER_OF_ERRORS) {
  $_SESSION['validation_err'] = $err;
  header('Location: search.php');
  exit();
} else {
  //検索件数取得
  $parts_count = PartsLogic::totalParts();
}


//ページネーション
$count = array_column($parts_count, 'count'); //トータルデータ数
$per_page = TOTAL_RECORDS_PER_PAGE; //1ページあたりのデータ件数
$max_page = ceil($count[0] / $per_page); //最大ページ数

//で渡されたページ確認
if (!isset($_GET['page'])) {
  $now = 1;
} else {
  $now = $_GET['page'];
}

//検索パーツ取得、parts.id partname img_path
$searchs = PartsLogic::searchParts($now, $per_page);
for ($key = 0; $key < count((array)$searchs); $key++) {
  $search = $searchs;
}

//getpartsの配列から単一のカラムを返す
if (!empty($search)) {
  $num_data = count((array)$search); //データ数
} else {
  //検索結果が０件
  $search_srr = $_SESSION['search_err'];
  $num_data = 0;
}

//全データ件数表示
$current = $now * $num_data;
$total_num = '全' . $count[0] . '件中 ' . $current . '件';

//検索結果から選ばれたパーツ formの値をセッションに保存
if (!empty($_POST)) {
  $_SESSION['detail_parts'] = $_POST;
  header('Location: parts_display.php');
  exit();
}

include('_header.php');

?>

<div class="container">
  <?php if (!empty($search_srr)) : ?>
    <h3 class="title-center">検索結果</h3>
    <table class="table">
      <thead>
        <tr>
          <td>
            <div class="h4 text-danger mt-5"><?= Utils::h($search_srr); ?></div>
          </td>
        </tr>
      </thead>
    </table>
    <form action="search.php" method="get">
      <div class="container text-center">
        <div class="d-flex flex-row-reverse">
          <button class="btn btn-primary rounded-pill">戻る</button>
        </div>
      </div>
    </form>
  <?php else : ?>
    <h1 class="h2 mb-1 mt-4 title-center">検索結果</h1>
    <div class="d-flex flex-wrap flex-fill mt-4">
      <?php foreach ((array)$searchs as $disp) : ?>
        <form class="border rounded m-1" action="" method="post">
          <button class="but btn-link"><img class=" get-icon" src="<?= Utils::h($disp['img_path']); ?>" alt=""><br>
            <p class="h6"><?= Utils::h($disp['partname']); ?></p>
          </button>
          <input type="hidden" name="id" value="<?= Utils::h($disp['id']); ?>">
        </form>
      <?php endforeach; ?>
    </div>


    <div class="text-center mt-3 mb-2">
      <p><?= Utils::h($total_num) ?></p>
    </div>
    <nav>
      <ul class="pagination justify-content-center">
        <?= Utils::h(Paging::paging($max_page, $now, 2, $url)); ?>
      </ul>
    </nav>

    <form action="search.php" method="get">
      <div class="container text-center">
        <div class="d-flex flex-row-reverse">
          <button class="btn btn-primary rounded-pill">戻る</button>
        </div>
      </div>
    </form>
  <?php endif; ?>
</div>

<?php
include('_footer.php');
