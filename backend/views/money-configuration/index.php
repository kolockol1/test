<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Money Configurations';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="money-configuration-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Money Configuration', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'left_amount',
            'min_limit',
            'max_limit',
            'conversion_ratio',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
