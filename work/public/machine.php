<?php

require_once(__DIR__ . '/../app/config.php');

/**
 * 工場機器登録フォーム
 */
var_dump($_SESSION['machine']);


include('_header.php');
?>
<h1>機器詳細</h1>

<div class="container text-center">
    <div class="d-flex flex-row-reverse">
        <a href="plant.php"><button class="btn btn-primary rounded-pill">戻る</button></a>
    </div>
</div>

<?php
include('_footer.php');
