<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\activeRecords\MoneyConfiguration */

$this->title = 'Update Money Configuration: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Money Configurations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="money-configuration-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
