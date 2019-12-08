<?php
namespace frontend\controllers;

use common\service\RafflePrize;
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
    }

    public function actionDecline(int $id)
    {
        /** @var RafflePrize $rafflePrize */
        $rafflePrize = \Yii::$container->get('RafflePrize');
        $rafflePrize->decline(\Yii::$app->getUser()->getIdentity(), $id);
    }

    public function actionList()
    {

    }
}
