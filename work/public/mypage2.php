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
//PGET処理分岐
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // get値分岐
    $branch = $_GET['data'];
    switch ($branch) {
        case 'gear':
            header('Location: plant.php');
            break;
        case 'search':
            header('Location: search.php');
            break;
        case 'buy':
            header('Location: get_history.php');
            break;
    }
} else {
    
}

include('_header.php');

?>

<div class="container">

    <main class="m-auto">
        <div class="text-center">
            <a href="http://localhost:8562/mypage2.php?data=gear"><img class="img-size img-fluid m-4" src="./img/plant.png" alt="設備から検索"></a>
            <a href="http://localhost:8562/mypage2.php?data=search"><img class="img-size img-fluid m-4" src="./img/glass.png" alt="部品名から検索"></a>
            <a href="http://localhost:8562/mypage2.php?data=buy"><img class="img-size img-fluid m-4" src="./img/buy1.png" alt="購入履歴から検索"></a>
        </div>
    </main>

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
