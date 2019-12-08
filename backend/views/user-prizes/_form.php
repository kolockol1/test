<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\activeRecords\UserPrizesModel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-prizes-model-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'date_create')->textInput() ?>

    <?= $form->field($model, 'prize_type')->textInput() ?>

    <?= $form->field($model, 'prize_amount')->textInput() ?>

    <?= $form->field($model, 'prize_status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
