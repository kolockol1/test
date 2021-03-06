<?php

use common\repository\BonusPointsDatabaseRepository;
use common\repository\MaterialItemDatabaseRepository;
use common\repository\MoneyDatabaseRepository;
use common\service\MoneyWithdrawal;
use common\service\PrizeAmountGenerator;
use common\service\PrizeConverter;
use common\service\PrizeLoader;
use common\service\RafflePrize;
use yii\base\BootstrapInterface;
use common\domain\prize\money\Repository as MoneyRepository;
use common\domain\prize\bonusPoints\Repository as BonusPointsRepository;
use common\domain\prize\materialItem\Repository as MaterialItemRepository;

class bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $container = \Yii::$container;
        $container->set('RafflePrize', RafflePrize::class);
        $container->set('PrizeLoader', PrizeLoader::class);
        $container->set('PrizeAmountGenerator', PrizeAmountGenerator::class);
        $container->set('PrizeConverter', PrizeConverter::class);
        $container->set('MoneyWithdrawal', MoneyWithdrawal::class);
        $container->set(MoneyRepository::class, MoneyDatabaseRepository::class);
        $container->set(BonusPointsRepository::class, BonusPointsDatabaseRepository::class);
        $container->set(MaterialItemRepository::class, MaterialItemDatabaseRepository::class);
    }
}
