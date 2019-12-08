<?php
namespace common\repository;

use common\activeRecords\UserPrizesModel;
use common\domain\prize\money\Money;
use common\domain\prize\money\Repository;
use common\domain\prize\Prize;
use yii\web\IdentityInterface;

class MoneyDatabaseRepository implements Repository
{

    /**
     * {@inheritdoc}
     */
    public function getById(IdentityInterface $identity, int $id): Prize
    {
        $model = UserPrizesModel::findOne(['id' => $id, 'user_id' => $identity->getId()]);

        if ($model === null) {
            throw new \RuntimeException('Not found prize model for user_id #' . $identity->getId() .
                ' and id #' . $id);
        }

        return Money::fromStorage($identity, $model);
    }

    /**
     * {@inheritdoc}
     */
    public function save(Money $money): void
    {
        $model = $money->toStorage(new UserPrizesModel());
        $model->save();
    }

    /**
     * {@inheritdoc}
     */
    public function createNew(IdentityInterface $identity, int $amount): Money
    {
        return Money::generateNewInstance($identity, $amount);
    }
}