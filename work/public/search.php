<?php

require_once(__DIR__ . '/../app/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    //リンクの値を取得
    $_SESSION['category'] = $_GET['data'];
    isset($_SESSION['category']) ? header('Location: get_parts.php?page=1') . exit() : false;
}

//パーツ検索バリデーション結果の表示処理
if (isset($_SESSION['validation_err'])) {
    $validation_srr = $_SESSION['validation_err'];
    unset($_SESSION['validation_err']);
}



include('_header.php');
?>
<div class="container">
    <h1>部品カテゴリ検索</h1>

    <?php if (isset($validation_srr['search_category_err'])) : ?>
        <div role="alert">
            <h5><span class="text-size badge bg-danger text-light"><i class="icon bi bi-exclamation-circle"></i> <?= Utils::h($validation_srr['search_category_err']); ?></span></h5>
        </div>
    <?php endif; ?>

    <p class="h4 rounded bg1 ps-2 mt-3">配管・水廻り部材・ホース</p>
    <div class="d-flex flex-wrap">
        <ul class="list-group">
            <li class="list-group-item me-1">
                <a href="search.php?data=バルブ"><img class="search-icon" src="./img/search_icon/valve.jpg" alt="バルブ"><br>
                    <p class="text-center">バルブ類</p>
                </a>
            </li>
        </ul>
        <ul class="list-group">
            <li class="list-group-item me-1">
                <a href="search.php?data=ポンプ"><img class="search-icon" src="./img/search_icon/viking_pump.jpeg" alt="ポンプ類"><br>
                    <p class="text-center">ポンプ類</p>
                </a>
            </li>
        </ul>
        <ul class="list-group">
            <li class="list-group-item me-1">
                <a href="search.php?data=配管"><img class="search-icon" src="./img/search_icon/tugite.webp" alt="継手"><br>
                    <p class="text-center">継手</p>
                </a>
            </li>
        </ul>
        <ul class="list-group">
            <li class="list-group-item me-1">
                <a href="search.php?data=カムロック"><img class="search-icon" src="./img/search_icon/camlock.webp" alt="カムロック"><br>
                    <p class="text-center">カムロック</p>
                </a>
            </li>
        </ul>
        <ul class="list-group">
            <li class="list-group-item me-1">
                <a href="search.php?data=ホース"><img class="search-icon" src="./img/search_icon/chemical_hose.jpeg" alt="ホース類"><br>
                    <p class="text-center">ホース類</p>
                </a>
            </li>
        </ul>
        <ul class="list-group">
            <li class="list-group-item me-1">
                <a href="search.php?data=圧力計"><img class="search-icon" src="./img/search_icon/press_gauge.webp" alt="圧力計"><br>
                    <p class="text-center">圧力計</p>
                </a>
            </li>
        </ul>
    </div>

    <p class="h4 rounded bg2 ps-2 mt-3">エアツール</p>
    <div class="d-flex flex-wrap">
        <ul class="list-group">
            <li class="list-group-item me-1">
                <a href="search.php?data=エアホース"><img class="search-icon" src="./img/search_icon/air_hose.webp" alt="ホース類"><br>
                    <p class="text-center">ホース類</p>
                </a>
            </li>
        </ul>
        <ul class="list-group">
            <li class="list-group-item me-1">
                <a href="search.php?data=カプラー"><img class="search-icon" src="./img/search_icon/air_coupler.webp" alt="カプラー類"><br>
                    <p class="text-center">カプラー類</p>
                </a>
            </li>
        </ul>
        <ul class="list-group">
            <li class="list-group-item me-1">
                <a href="search.php?data=レギュレータ"><img class="search-icon" src="./img/search_icon/regulator.webp" alt="レギュレータ類"><br>
                    <p class="text-center">レギュレータ類</p>
                </a>
            </li>
        </ul>
    </div>

    <p class="h4 rounded bg3 ps-2 mt-5">車輪/保管/梱包用品/テープ</p>
    <div class="d-flex flex-wrap">
        <ul class="list-group">
            <li class="list-group-item me-1">
                <a href="search.php?data=キャスター"><img class="search-icon" src="./img/search_icon/caster2-02.webp" alt="キャスター"><br>
                    <p class="text-center">キャスター</p>
                </a>
            </li>
        </ul>
        <ul class="list-group">
            <li class="list-group-item me-1">
                <a href="search.php?data=車輪"><img class="search-icon" src="./img/search_icon/wheel.webp" alt="車輪"><br>
                    <p class="text-center">車輪</p>
                </a>
            </li>
        </ul>
        <ul class="list-group">
            <li class="list-group-item me-1">
                <a href="search.php?data=テープ"><img class="search-icon" src="./img/search_icon/line_tape.jpg" alt="テープ"><br>
                    <p class="text-center">テープ</p>
                </a>
            </li>
        </ul>
    </div>


    <p class="h4 rounded bg4 ps-2 mt-5">安全保護具・作業服・安全靴</p>
    <div class="d-flex flex-wrap">

    </div>
</div>
<form action="mypage2.php" method="get">
    <div class="container text-center">
        <div class="d-flex flex-row-reverse">
            <button class="btn btn-primary rounded-pill mt-3">マイページ</button>
        </div>
    </div>
</form>
<?php
include('_footer.php');
