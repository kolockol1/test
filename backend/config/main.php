<?php

use common\repository\BonusPointsDatabaseRepository;
use common\repository\MaterialItemDatabaseRepository;
use common\repository\MoneyDatabaseRepository;
use common\service\MoneyWithdrawal;
use common\service\PrizeAmountGenerator;
use common\service\PrizeConverter;
use common\service\PrizeLoader;
use common\service\RafflePrize;
use common\domain\prize\money\Repository as MoneyRepository;
use common\domain\prize\bonusPoints\Repository as BonusPointsRepository;
use common\domain\prize\materialItem\Repository as MaterialItemRepository;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'container' => [
        'singletons' => [
            'RafflePrize' => ['class' => RafflePrize::class],
            'PrizeLoader' => ['class' => PrizeLoader::class],
            'PrizeAmountGenerator' => ['class' => PrizeAmountGenerator::class],
            'PrizeConverter' => ['class' => PrizeConverter::class],
            'MoneyWithdrawal' => ['class' => MoneyWithdrawal::class],
            MoneyRepository::class => ['class' => MoneyDatabaseRepository::class],
            BonusPointsRepository::class => ['class' => BonusPointsDatabaseRepository::class],
            MaterialItemRepository::class => ['class' => MaterialItemDatabaseRepository::class],
        ],
    ],
    'modules' => [],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
    ],
    'params' => $params,
];
