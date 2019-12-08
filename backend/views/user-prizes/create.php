<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\activeRecords\UserPrizesModel */

$this->title = 'Create User Prizes Model';
$this->params['breadcrumbs'][] = ['label' => 'User Prizes Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-prizes-model-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
