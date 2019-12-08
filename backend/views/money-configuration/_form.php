<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\activeRecords\MoneyConfiguration */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="money-configuration-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'left_amount')->textInput() ?>

    <?= $form->field($model, 'min_limit')->textInput() ?>

    <?= $form->field($model, 'max_limit')->textInput() ?>

    <?= $form->field($model, 'conversion_ratio')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
