<?php

namespace console\controllers;

use common\service\MoneyWithdrawal;
use common\service\PrizeLoader;
use yii\base\InvalidConfigException;
use yii\console\Controller;

class MoneyWithdrawalController extends Controller
{
    public function actionProcess(): void
    {
        /** @var PrizeLoader $prizeLoader */
        $prizeLoader = \Yii::$container->get('PrizeLoader');
        /** @var MoneyWithdrawal $moneyWithdrawal */
        $moneyWithdrawal = \Yii::$container->get('MoneyWithdrawal');
        $prizes = $prizeLoader->loadUnpaidMoney();

        foreach ($prizes as $prize) {
            try {
                $moneyWithdrawal->withdrawal($prize);
            } catch (InvalidConfigException $e) {
            }
        }
    }
}
