<?php

use common\repository\BonusPointsDatabaseRepository;
use common\repository\MoneyDatabaseRepository;
use common\service\RafflePrize;
use yii\base\BootstrapInterface;
use common\domain\prize\money\Repository as MoneyRepository;
use common\domain\prize\bonusPoints\Repository as BonusPointsRepository;

class bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $container = \Yii::$container;
        $container->set('RafflePrize', RafflePrize::class);
        $container->set(MoneyRepository::class, MoneyDatabaseRepository::class);
        $container->set(BonusPointsRepository::class, BonusPointsDatabaseRepository::class);
    }
}
