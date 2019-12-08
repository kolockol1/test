<?php

/* @var $this yii\web\View */
/* @var $description string */
/* @var $id int */

use yii\helpers\Html;
use yii\helpers\Url;

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>What do you want to do with your prize? <?= $description ?></p>

    <p><a class="btn btn-lg btn-success" href="<?= Url::to(['/prize/apply', 'id' => $id,]) ?>">Apply!</a></p>

    <p><a class="btn btn-lg btn-success" href="<?= Url::to(['/prize/decline', 'id' => $id,]) ?>">Decline!</a></p>

</div>
