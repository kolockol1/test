<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\activeRecords\UserPrizesModel */

$this->title = 'Update User Prizes Model: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'User Prizes Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-prizes-model-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
