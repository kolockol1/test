<?php
namespace frontend\controllers;

use common\domain\prize\money\Money;
use common\service\PrizeLoader;
use common\service\RafflePrize;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\data\ArrayDataProvider;
use yii\web\Controller;

class PrizeController extends Controller
{
    public function actionGenerate()
    {
        /** @var RafflePrize $rafflePrize */
        $rafflePrize = \Yii::$container->get('RafflePrize');
        $prize = $rafflePrize->generate(\Yii::$app->getUser()->getIdentity());
        $prizeId = $rafflePrize->save($prize);

        return $this->render('generate', [
            'id' => $prizeId,
            'description' => $prize->getDescription(),
        ]);
    }

    public function actionApply(int $id)
    {
        /** @var RafflePrize $rafflePrize */
        $rafflePrize = \Yii::$container->get('RafflePrize');
        $rafflePrize->apply(\Yii::$app->getUser()->getIdentity(), $id);

        return $this->redirect(['list']);
    }

    public function actionDecline(int $id)
    {
        /** @var RafflePrize $rafflePrize */
        $rafflePrize = \Yii::$container->get('RafflePrize');
        $rafflePrize->decline(\Yii::$app->getUser()->getIdentity(), $id);

        return $this->redirect(['list']);
    }

    public function actionConvert(int $id) {
        /** @var RafflePrize $rafflePrize */
        $rafflePrize = \Yii::$container->get('RafflePrize');
        $rafflePrize->convert(\Yii::$app->getUser()->getIdentity(), $id);

        return $this->redirect(['list']);
    }

    public function actionWithdrawal(int $id) {
        /** @var RafflePrize $rafflePrize */
        $rafflePrize = \Yii::$container->get('RafflePrize');
        $rafflePrize->moneyWithdrawal(\Yii::$app->getUser()->getIdentity(), $id);

        return $this->redirect(['list']);
    }

    public function actionList()
    {
        /** @var PrizeLoader $prizeLoader */
        $prizeLoader = \Yii::$container->get('PrizeLoader');
        $prizes = $prizeLoader->loadAll(\Yii::$app->getUser()->getIdentity());
        $resultArray = [];

        foreach ($prizes as $prize) {
            $actions = $prize->getSupportedActions();

            $resultArray[] = [
                'id' => $prize->getId(),
                'description' => $prize->getDescription(),
                'actionConvert' => $actions['actionConvert'] ?? '',
                'actionWithdrawal' => $actions['actionWithdrawal'] ?? '',
            ];
        }

        $dataProvider = new ArrayDataProvider(['allModels' => $resultArray, 'pagination' => false,]);

        return $this->render('list', [
            'dataProvider' => $dataProvider,
        ]);
    }
}
