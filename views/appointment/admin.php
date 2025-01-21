<?php

use yii\helpers\Html;

$this->title = 'Foglalások listája';
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="logout">
    <?= Html::a('Kijelentkezés', ['site/logout'], [
        'class' => 'btn btn-danger',
        'data-method' => 'post',
        'data-confirm' => 'Biztosan kijelentkezel?',
    ]) ?>
</div>
<div class="vissza">
    <?= Html::a('Vissza a kezdőlapra (Bejelentkezve maradva)', ['appointment/index'], [
        'class' => 'btn btn-primary',
        'data-method' => 'post',
    ]) ?>
</div>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Név</th>
            <th>Email</th>
            <th>Telefonszám</th>
            <th>Dátum</th>
            <th>Időpont</th>
            <th>Művelet</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($appointments as $appointment): ?>
            <tr>
                <td><?= Html::encode($appointment->name) ?></td>
                <td><?= Html::encode($appointment->email) ?></td>
                <td><?= Html::encode($appointment->phone) ?></td>
                <td><?= Html::encode($appointment->date) ?></td>
                <td><?= Html::encode($appointment->time) ?></td>
                <td>
                    <?= Html::a('❌', ['appointment/delete', 'id' => $appointment->id], [
                        'class' => 'btn btn-dark',
                        'data-confirm' => 'Biztosan törölni szeretnéd ezt a foglalást?',
                        'data-method' => 'post',
                    ]) ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>