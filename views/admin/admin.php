<?php

use yii\helpers\Html;

$this->title = 'Foglalások listája';
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="button-box">
<div class="logout">
    <?= Html::a('Kijelentkezés', ['site/logout'], [
        'class' => 'btn btn-danger',
        'data-method' => 'post',
        'data-confirm' => 'Biztosan kijelentkezel?',
    ]) ?>
</div>
<div class="vissza">
    <?= Html::a('Vissza a kezdőlapra (Bejelentkezve maradva)', ['site/index'], [
        'class' => 'btn btn-primary',
        'data-method' => 'post',
    ]) ?>
</div>
</div>


<div id="calendar"></div>

<?php
$this->registerJsFile('https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js', ['depends' => [\yii\web\JqueryAsset::class]]);
$this->registerJsFile('https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/locales/hu.js', ['depends' => [\yii\web\JqueryAsset::class]]);
$this->registerJsFile('@web/js/calendar-admin.js', ['depends' => [\yii\web\JqueryAsset::class]]);
?>