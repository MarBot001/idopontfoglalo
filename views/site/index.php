<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Időpontfoglaló rendszer';

?>


<!-- Időpontfoglaló űrlap -->
<div class="appointment-form">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php $form = ActiveForm::begin(); ?>
    <div class="row ">
        <div class="col-md-6">
            <?= $form->field($model, 'name')->textInput([
                'maxlength' => true,
                'placeholder' => 'pl. Példa János'
            ])->label('Teljes név') ?>

            <?= $form->field($model, 'email')->input('email', [
                'placeholder' => 'pl. valaki@email.com'
            ])->label('Email cím') ?>

            <?= $form->field($model, 'phone')->textInput([
                'maxlength' => true,
                'placeholder' => 'pl. +36 30 123 4567'
            ])->label('Telefonszám') ?>
        </div>


        <div class="col-md-6">
            <?= $form->field($model, 'service')->dropDownList($services, ['prompt' => ''])->label('Szolgáltatás') ?>
            <?= $form->field($model, 'comments')->textarea([
                'rows' => 5,
                'placeholder' => 'További megjegyzés (nem kötelező)'
            ])->label('Megjegyzés') ?>

        </div>
        <div id="calendar"></div>
        <?= $form->field($model, 'date')->textInput(['readonly' => true, 'id' => 'selected-date'])->label(false) ?>
        <div class="button-box">
            <?= Html::submitButton('Foglalás mentése', ['class' => 'btn btn-success']) ?>
        </div>

        <?= $form->field($model, 'time')->textInput(['readonly' => true, 'id' => 'selected-time'])->label(false) ?>

        <?php ActiveForm::end(); ?>
    </div>



</div>

<?php
$this->registerJsFile('https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js', ['depends' => [\yii\web\JqueryAsset::class]]);
$this->registerJsFile('https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/locales/hu.js', ['depends' => [\yii\web\JqueryAsset::class]]);
$this->registerJsFile('https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/main.min.js', ['depends' => [\yii\web\JqueryAsset::class]]);
$this->registerJsFile('@web/js/calendar.js', ['depends' => [\yii\web\JqueryAsset::class]]);
?>
<?php
if (Yii::$app->session->hasFlash('error')) {
    $errorMessage = Yii::$app->session->getFlash('error');
    $this->registerJs("alert('" . addslashes($errorMessage) . "');");
}
if (Yii::$app->session->hasFlash('success')) {
    $successMessage = Yii::$app->session->getFlash('success');
    $this->registerJs("alert('" . addslashes($successMessage) . "');");
}
?>