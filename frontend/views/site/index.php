<?php

use yii\helpers\Url;
/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Congratulations! Do you want to get prize?</h1>

        <p><a class="btn btn-lg btn-success" href="<?= Url::to('/prize/generate') ?>">Get prize!</a></p>
    </div>

</div>
