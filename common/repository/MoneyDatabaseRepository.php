<?php
namespace common\repository;

use common\activeRecords\MoneyConfiguration;
use common\activeRecords\UserPrizesModel;
use common\domain\prize\money\Money;
use common\domain\prize\money\Repository;
use common\domain\prize\Prize;
use common\domain\prize\Statuses;
use common\exception\ExceptionCodes;
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
                ' and id #' . $id, ExceptionCodes::NOT_FOUND_PRIZE_MODEL);
        }

        return Money::fromStorage($identity, $model);
    }

    /**
     * {@inheritdoc}
     */
    public function save(Money $money): int
    {
        if (null !== $money->getId()) {
            $userPrizesModel = UserPrizesModel::findOne(['id' => $money->getId()]);
        }

        $model = $money->toStorage($userPrizesModel ?? new UserPrizesModel());

        $transaction = UserPrizesModel::getDb()->beginTransaction();
        try {
            $model->save();

            if (Statuses::APPLIED === $model->getStatus()) {
                $moneyConfiguration = MoneyConfiguration::getSingle();
                if (null === $moneyConfiguration || $moneyConfiguration->left_amount - $money->getAmount() < 0) {
                    throw new \RuntimeException('All real money are gone');
                }
                $moneyConfiguration->left_amount -= $money->getAmount();
                $moneyConfiguration->save();
            }

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
     * {@inheritdoc}
     */
    public function createNew(IdentityInterface $identity, int $amount): Money
    {
        return Money::generateNewInstance($identity, $amount);
    }
}