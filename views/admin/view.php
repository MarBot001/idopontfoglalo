<?php

use yii\helpers\Html;

$this->title = 'Foglalás részletei';
?>

<h1>Foglalás részletei</h1>

<ul>
    <li><strong>Név:</strong> <?= Html::encode($appointment->name) ?></li>
    <li><strong>Email:</strong> <?= Html::encode($appointment->email) ?></li>
    <li><strong>Telefonszám:</strong> <?= Html::encode($appointment->phone) ?></li>
    <li><strong>Dátum:</strong> <?= Html::encode($appointment->date) ?></li>
    <li><strong>Időpont:</strong> <?= Html::encode($appointment->time) ?></li>
    <li><strong>Szolgáltatás:</strong> <?= Html::encode($appointment->service) ?></li>
    <li><strong>Megjegyzés:</strong> <?= nl2br(Html::encode($appointment->comments)) ?></li>
</ul>

<p>
    <?= Html::a('❌ Foglalás törlése', ['admin/delete', 'id' => $appointment->id], [
        'class' => 'btn btn-danger',
        'data-confirm' => 'Biztosan törölni szeretnéd ezt a foglalást?',
        'data-method' => 'post',
    ]) ?>
</p>

<p>
    <?= Html::a('⬅️ Vissza az admin felületre', ['admin/admin'], ['class' => 'btn btn-secondary']) ?>
</p>
