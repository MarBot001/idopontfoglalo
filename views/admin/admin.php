<?php

use yii\helpers\Html;

$this->title = 'Adminisztrátor felület';
?>


<div class="admin">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="button-box">
        <div class="logout">
            <?= Html::a('<i class="bi bi-box-arrow-left"></i>', ['site/logout'], [
                'class' => 'btn btn-danger',
                'title' => 'Kijelentkezés',
                'data-method' => 'post',
                'data-confirm' => 'Biztosan kijelentkezel?',
            ]) ?>
        </div>
        <div class="vissza">
            <?= Html::a('<i class="bi bi-house"></i>', ['site/index'], [
                'class' => 'btn btn-primary',
                'title' => 'Vissza a főoldalra',
                'data-method' => 'post',
            ]) ?>
        </div>
    </div>




<div id="calendar"></div>
</div>
<?php
$this->registerJsFile('https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js', ['depends' => [\yii\web\JqueryAsset::class]]);
$this->registerJsFile('https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/locales/hu.js', ['depends' => [\yii\web\JqueryAsset::class]]);
$this->registerJsFile('@web/js/calendar-admin.js', ['depends' => [\yii\web\JqueryAsset::class]]);
?>