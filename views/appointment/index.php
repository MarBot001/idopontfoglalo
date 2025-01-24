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
    <p>Válaszd ki a megfelelő napot és időpontot a naptárban!<br>Előre legfeljebb 10 munkanapig foglalhatsz!</p>
    <div id="calendar"></div>
    <?= $form->field($model, 'date')->textInput(['readonly' => true, 'id' => 'selected-date'])->label(false) ?>
    <?= $form->field($model, 'time')->textInput(['readonly' => true, 'id' => 'selected-time'])->label(false) ?>

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

