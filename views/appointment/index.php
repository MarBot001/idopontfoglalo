<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Időpontfoglaló';

?>

<h1><?= Html::encode($this->title) ?></h1>


<!-- Időpontfoglaló űrlap -->
<div class="appointment-form">
    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Név') ?>
    <?= $form->field($model, 'email')->input('email')->label('Email cím') ?>
    <?= $form->field($model, 'phone')->textInput(['maxlength' => true])-> label('Telefonszám') ?>
    <p>Válaszd ki a megfelelő napot a naptárban!<br>Előre legfeljebb 10 munkanapig foglalhatsz!</p>
    <div id="calendar"></div>
    <?= $form->field($model, 'date')->textInput(['readonly' => true, 'id' => 'selected-date'])-> label('') ?>
    <?= $form->field($model, 'time')->label('Idő')->dropDownList([
        '08:00' => '08:00', '08:30' => '08:30', '09:00' => '09:00', '09:30' => '09:30',
        '10:00' => '10:00', '10:30' => '10:30', '11:00' => '11:00', '11:30' => '11:30',
        '12:00' => '12:00', '12:30' => '12:30', '13:00' => '13:00', '13:30' => '13:30',
        '14:00' => '14:00', '14:30' => '14:30', '15:00' => '15:00', '15:30' => '15:30'
    ], ['prompt' => 'Válassz időpontot']) ?>

    <div class="form-group">
        <?= Html::submitButton('Foglalás mentése', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<!-- FullCalendar -->
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/locales/hu.js"></script>
<?php
$this->registerJsFile('https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/main.min.js', ['depends' => [\yii\web\JqueryAsset::class]]);
$this->registerJsFile('@web/js/calendar.js', ['depends' => [\yii\web\JqueryAsset::class]]);
?>
