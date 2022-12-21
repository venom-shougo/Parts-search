<?php

require_once(__DIR__ . '/../app/config.php');

//ページネーション用URL取得
if (!empty($_SERVER['SCRIPT_NAME'])) {
  $url = $_SERVER['SCRIPT_NAME'];
}

// $referer = $_SERVER['HTTP_REFERER'];


//パーツ検索入力の検査
$err = [];
$err = PartsValidateForm::searchParts();
if (count($err) > 0) {
  $_SESSION['validation_err'] = $err;
  header('Location: search.php');
  exit();
} else {
  //検索件数取得
  $parts_count = PartsLogic::totalParts();
}


//ページネーション
$count = array_column($parts_count, 'count'); //トータルデータ数
$per_page = 5; //1ページあたりのデータ件数
$max_page = ceil($count[0] / $per_page); //最大ページ数

//で渡されたページ確認
if (!isset($_GET['page'])) {
  $now = 1;
} else {
  $now = $_GET['page'];
}

//検索パーツ取得
$search = PartsLogic::searchParts($now, $per_page);
$img = ImageAcqu::getImage(null); //画像id、パス全件取得
$id_path = array_column((array)$img, 'img_path', 'id'); //idをキーにimg_pathを値にする
$parts_img = array_column((array)$search, 'id', 'image_id'); //image_idをキーにする
$image_path = array_intersect_key($id_path, $parts_img); //同じキーと値を取得

//getpartsの配列から単一のカラムを返す
if (!empty($search)) {
  $num_data = count((array)$search); //データ数
  $parts_id = array_column((array)$search, 'partname', 'id'); //idをキーにしたパーツ名
} else {
  //検索結果が０件
  $search_srr = $_SESSION['search_err'];
  $num_data = 0;
}
var_dump($parts_id);
var_dump($num_data);
var_dump($image_path);
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
          <th class="col-2">No</th>
          <th class="col-10">品名</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>
            <div class="h4 text-danger"><?= Utils::h($search_srr); ?></div>
          </td>
        </tr>
      </tbody>
    </table>
    <form action="mypage.php" method="get">
      <div class="container text-center">
        <div class="d-flex flex-row-reverse">
          <button class="btn btn-primary rounded-pill">戻る</button>
        </div>
      </div>
    </form>
  <?php else : ?>
    <h1 class="h2 mb-1 mt-4 title-center">検索結果</h1>
    <table class="table">
      <thead>
        <tr>
          <!-- <th class="col">No</th>
              <th class="col-11">品名</th> -->
        </tr>
      </thead>
    </table>
    <tbody></tbody>
    <div class="d-flex flex-wrap">
      <ul class="list-group">
        <?php foreach ((array)$image_path as $path) : ?>
          <li class="list-group-item">
            <img class=" get-icon" src="<?= Utils::h($path); ?>" alt="">
          </li>
        <?php endforeach; ?>
      </ul>
      <ul>
        <?php $i = 1; foreach ((array)$parts_id as $key => $disp) : ?>
          <form action="" method="post">
            <?= $i . '. '; ?>
            <li class="list-group-item">
              <button class="but btn-link ms-4"><?= Utils::h($disp); ?></button>
              <input type="hidden" name="id" value="<?= Utils::h($key); ?>">
            </li>
          </form>
        <?php $i++; endforeach; ?>
      </ul>
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
