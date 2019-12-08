<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Prizes Models';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-prizes-model-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create User Prizes Model', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_id',
            'date_create',
            'prize_type',
            'prize_amount',
            //'prize_status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
