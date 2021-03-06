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
            'prize_status',

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Actions',
                'headerOptions' => ['style' => 'color:#337ab7'],
                'template' => '{view}{update}{send-post}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                            'title' => Yii::t('app', 'view'),
                        ]);
                    },

                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                            'title' => Yii::t('app', 'update'),
                        ]);
                    },
                    'send-post' => function ($url, $model) {
                        return \common\domain\prize\Prize::MATERIAL_ITEM === $model->prize_type ?
                            Html::a('<span class="glyphicon glyphicon-star"></span>', $url, ['title' => Yii::t('app', 'send by post'),]) :
                            '';
                    }

                ],
            ],
        ],
    ]); ?>


</div>
