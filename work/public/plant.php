<?php

//工場設備からパーツ検索処理

require_once(__DIR__ . '/../app/config.php');

//GET処理分岐
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($_GET['data']) {
        $_SESSION['machine'] = $_GET['data'];
        header('Location: machine.php');
        exit();
    }
}


include('_header.php');
?>

<h1>工場機器検索</h1>
<div class="container">

    <main class="m-auto">
        <div class="d-flex justify-content-center">
            <a href="http://localhost:8562/plant.php?data=strainer_white"><img class="img-size img-fluid mt-4 mb-0" src="./img/machine/white_strainer.jpg" alt="設備から検索"><br>
            </a>
            <a href="http://localhost:8562/plant.php?data=strainer_2"><img class="img-size img-fluid mt-4 mb-0" src="./img/machine/automatic_No2.jpg" alt="購入履歴から検索"><br>
            </a>
            <a href="http://localhost:8562/plant.php?data=strainer_6"><img class="img-size img-fluid mt-4 mb-0" src="./img/machine/clear_strainer_No6.jpg" alt="購入履歴から検索"><br>
            </a>
            <a href="http://localhost:8562/plant.php?data=tank_J"><img class="img-size img-fluid mt-4 mb-0" src="./img/machine/tank_J.jpg" alt="部品名から検索"><br>
            </a>
        </div>
    </main>
</div>


<?php
include('_footer.php');
