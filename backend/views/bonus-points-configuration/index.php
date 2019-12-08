<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bonus Points Configurations';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bonus-points-configuration-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Bonus Points Configuration', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'min_limit',
            'max_limit',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
