<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\activeRecords\BonusPointsConfiguration */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bonus-points-configuration-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'min_limit')->textInput() ?>

    <?= $form->field($model, 'max_limit')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
