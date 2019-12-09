<?php

/* @var $this yii\web\View */
/* @var $dataProvider ArrayDataProvider */

use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use yii\grid\GridView;

$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget(
        [
            'dataProvider' => $dataProvider,
            'columns' => [
                'id',
                'description',
                [
                    'attribute' => 'actionConvert',
                    'value' => function ($model) {
                        return $model['actionConvert'] ? Html::a('convert', $model['actionConvert']) : '';
                    },
                    'format' => 'raw',
                ],
            ],
        ]
    ); ?>
</div>
