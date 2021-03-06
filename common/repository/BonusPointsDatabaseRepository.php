<?php
namespace common\repository;

use common\activeRecords\UserPrizesModel;
use common\domain\prize\bonusPoints\BonusPoints;
use common\domain\prize\bonusPoints\Repository;
use common\domain\prize\Prize;
use common\exception\ExceptionCodes;
use yii\web\IdentityInterface;

class BonusPointsDatabaseRepository implements Repository
{

    /**
     * @inheritDoc
     */
    public function getById(IdentityInterface $identity, int $id): Prize
    {
        $model = UserPrizesModel::findOne(['id' => $id, 'user_id' => $identity->getId()]);

        if ($model === null) {
            throw new \RuntimeException('Not found prize model for user_id #' . $identity->getId() .
                ' and id #' . $id, ExceptionCodes::NOT_FOUND_PRIZE_MODEL);
        }

        return BonusPoints::fromStorage($identity, $model);
    }

    /**
     * @inheritDoc
     */
    public function save(BonusPoints $bonusPoints): int
    {
        if (null !== $bonusPoints->getId()) {
            $userPrizesModel = UserPrizesModel::findOne(['id' => $bonusPoints->getId()]);
        }

        $model = $bonusPoints->toStorage($userPrizesModel ?? new UserPrizesModel());
        $transaction = UserPrizesModel::getDb()->beginTransaction();
        try {
            $model->save();

            $transaction->commit();
        } catch(\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch(\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }

        return $model->getId();
    }

    /**
     * @inheritDoc
     */
    public function createNew(IdentityInterface $identity, int $amount): BonusPoints
    {
        return BonusPoints::generateNewInstance($identity, $amount);
    }
}