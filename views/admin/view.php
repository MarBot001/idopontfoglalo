<?php

use yii\helpers\Html;

$this->title = 'Foglalás részletei';
?>

<div class="view">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="button-box">
        <?= Html::a('<i class="bi bi-trash"></i>', ['admin/delete', 'id' => $appointment->id], [
            'class' => 'btn btn-danger',
            'title' => 'Törlés',
            'data-confirm' => 'Biztosan törölni szeretnéd ezt a foglalást?',
            'data-method' => 'post',
        ]) ?>

        <?= Html::a('<i class="bi bi-arrow-left-square"></i>', ['admin/admin'], [
            'class' => 'btn btn-primary',
            'title' => 'Vissza az adminisztrátor felületre',
            ]) ?>
    </div>
    <ul>
        <li><strong>Név:</strong> <?= Html::encode($appointment->name) ?></li>
        <li><strong>Email:</strong> <?= Html::encode($appointment->email) ?></li>
        <li><strong>Telefonszám:</strong> <?= Html::encode($appointment->phone) ?></li>
        <li><strong>Dátum:</strong> <?= Html::encode($appointment->date) ?></li>
        <li><strong>Időpont:</strong> <?= Html::encode($appointment->time) ?></li>
        <li><strong>Szolgáltatás:</strong> <?= Html::encode($appointment->service) ?></li>
        <li><strong>Megjegyzés:</strong><br><?= nl2br(Html::encode($appointment->comments)) ?></li>
    </ul>



</div>