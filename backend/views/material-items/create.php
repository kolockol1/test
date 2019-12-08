<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\activeRecords\MaterialItemsModel */

$this->title = 'Create Material Items Model';
$this->params['breadcrumbs'][] = ['label' => 'Material Items Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="material-items-model-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
