<?php

require_once(__DIR__ . '/../app/config.php');



include('_header.php');
?>
<div class="container">
    <h1>部品カテゴリ検索</h1>
    <p class="h4 rounded bg1 ps-2 mt-3">配管・水廻り部材/ポンプ/空圧・油圧機器・ホース</p>
    <div class="d-flex flex-wrap">
        <ul class="list-group">
            <li class="list-group-item me-1">
                <a href="http://"><img class="search-icon" src="./img/search_icon/valve.jpg" alt="バルブ"><br>
                    <p class="text-center">バルブ</p>
                </a>
            </li>
        </ul>
        <ul class="list-group">
            <li class="list-group-item me-1">
                <a href="http://"><img class="search-icon" src="./img/search_icon/tugite.webp" alt="バルブ"><br>
                    <p class="text-center">継手</p>
                </a>
            </li>
        </ul>
        <ul class="list-group">
            <li class="list-group-item me-1">
                <a href="http://"><img class="search-icon" src="./img/search_icon/camlock.webp" alt="バルブ"><br>
                    <p class="text-center">カムロック</p>
                </a>
            </li>
        </ul>
        <ul class="list-group">
            <li class="list-group-item me-1">
                <a href="http://"><img class="search-icon" src="./img/search_icon/air_hose.webp" alt="バルブ"><br>
                    <p class="text-center">エアツール</p>
                </a>
            </li>
        </ul>
        <ul class="list-group">
            <li class="list-group-item me-1">
                <a href="http://"><img class="search-icon" src="./img/search_icon/press_gauge.webp" alt="バルブ"><br>
                    <p class="text-center">圧力計</p>
                </a>
            </li>
        </ul>

    </div>
    <p class="h4 rounded bg2 ps-2 mt-5">車輪/保管/梱包用品/テープ</p>
    <div class="d-flex flex-wrap">
        <ul class="list-group">
            <li class="list-group-item me-1">
                <a href="http://"><img class="search-icon" src="./img/search_icon/caster2-02.webp" alt="バルブ"><br>
                    <p class="text-center">キャスター</p>
                </a>
            </li>
        </ul>
        <ul class="list-group">
            <li class="list-group-item me-1">
                <a href="http://"><img class="search-icon" src="./img/search_icon/wheel.webp" alt="バルブ"><br>
                    <p class="text-center">車輪</p>
                </a>
            </li>
        </ul>
        <ul class="list-group">
            <li class="list-group-item me-1">
                <a href="http://"><img class="search-icon" src="./img/search_icon/line_tape.jpg" alt="バルブ"><br>
                    <p class="text-center">テープ</p>
                </a>
            </li>
        </ul>
    </div>


    <p class="h4 rounded bg3 ps-2 mt-5">安全保護具・作業服・安全靴</p>
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
