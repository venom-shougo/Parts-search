<?php

require_once(__DIR__ . '/../app/config.php');

// トークン照会
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  Token::validateToken();
}
unset($_SESSION['csrf_token']);

//パーツ削除処理
if (!empty($_POST)) {
  if (isset($_POST['admin_pass'])) {
    $_SESSION['delete_parts'] = $_POST;
  }
}

$err = [];
$err = ValidateForm::adminPass();

if (count($err) > 0) {
  $_SESSION['admin_pass_err'] = $err;
  header('Location: parts_display.php');
  return;
} else {
  $delete = PartsLogic::deleteParts();
}

if (empty($delete)) {
  header('Location: parts_display.php');
  return;
}

include('_header.php');

?>

  <div class="container">
    <h3 class="text-center">部品削除完了</h3>
  </div>

  <div class="container text-center">
    <div class="d-flex flex-row-reverse">
      <form action="mypage.php" method="get">
        <button class="btn btn-primary">マイページ</button>
      </form>
    </div>
  </div>

<?php
  include('_footer.php');
