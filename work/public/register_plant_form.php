<?php

require_once(__DIR__ . '/../app/config.php');

include('_header.php');
?>
<div class="container">
    <p class="h3 text-center">機器登録画面</p>
    <form action="register_plant.php" method="post" enctype="multipart/form-data">

        <div class="form-floating-2 mb-3">
            <input class="form-control mb-1" type="text" name="machine_name" id="floatingInput" placeholder="機器名">
            <label for="floatingInput">機器名</label>
            <?php if (isset($err['machine_err'])) : ?>
                <div role="alert">
                    <h5><span class="badge bg-danger text-light"><i class="icon bi bi-exclamation-circle"></i> <?= Utils::h($err['machine_err']); ?></span></h5>
                </div>
            <?php endif; ?>
        </div>

        <div class="form-floating-2 mb-3">
            <input class="form-control mb-1" type="text" name="model_name" id="floatingInput" placeholder="機器番号">
            <label for="floatingInput">機器番号</label>
            <?php if (isset($err['model_err'])) : ?>
                <div role="alert">
                    <h5><span class="badge bg-danger text-light"><i class="icon bi bi-exclamation-circle"></i> <?= Utils::h($err['model_err']); ?></span></h5>
                </div>
            <?php endif; ?>
        </div>

        <div class="form-floating mb-3">
            <select class="form-select mb-1" name="category" id="floatingCelect" placeholder="カテゴリー">
                <option value="0">選択してください</option>
                <option value="バルブ">バルブ</option>
                <option value="配管">配管</option>
                <option value="カムロック">カムロック</option>
                <option value="計器">計器</option>
                <option value="ポンプ">ポンプ</option>
                <option value="エアツール">エアツール</option>
                <option value="キャスター">キャスター</option>
                <option value="掃除用具">掃除用具</option>
                <option value="表示類">表示類</option>
            </select>
            <label for="floatingInput">カテゴリー</label>
            <?php if (isset($err['category_err'])) : ?>
                <div role="alert">
                    <h5><span class="badge bg-danger text-light"><i class="icon bi bi-exclamation-circle"></i> <?= Utils::h($err['category_err']); ?></span></h5>
                </div>
            <?php endif; ?>
        </div>
        <div id="box"></div>

        <div class="mb-3">
            <!-- <span class="badge bg-danger text-light" for="floatingInput" id="image">画像選択</span> -->
            <input class="form-control mb-1" type="file" accep="image/*" name="image" aria-describedby="image">
            <?php if (isset($err['img_err'])) : ?>
                <div role="alert">
                    <h5><span class="badge bg-danger text-light"><i class="icon bi bi-exclamation-circle"></i> <?= Utils::h($err['img_err']); ?></span></h5>
                </div>
            <?php endif; ?>
            <?php if (isset($err2)) : ?>
                <div role="alert">
                    <h5><span class="badge bg-danger text-light"><i class="icon bi bi-exclamation-circle"></i> <?= Utils::h($err2); ?></span></h5>
                </div>
            <?php endif; ?>
        </div>

        <div class="form-floating-2 mb-3">
            <input class="form-control mb-1" type="text" name="image_name" id="floatingInput" placeholder="画像名">
            <label for="floatingInput">画像名</label>
            <?php if (isset($err['imgname_err'])) : ?>
                <div role="alert">
                    <h5><span class="badge bg-danger text-light"><i class="icon bi bi-exclamation-circle"></i> <?= Utils::h($err['imgname_err']); ?></span></h5>
                </div>
            <?php endif; ?>
        </div>

        <div class="d-grid gap-2">
            <button class="btn btn-primary btn-success btn-lg rounded-pill mb-5" type="submit">確認</button>
        </div>


    </form>
    <form action="mypage2.php" method="get">
        <div class="container text-center">
            <div class="d-flex flex-row-reverse">
                <button class="btn btn-primary rounded-pill">マイページ</button>
            </div>
        </div>
    </form>
</div>

<?php
include('_footer.php');
