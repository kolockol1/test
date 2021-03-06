<?php
namespace common\repository;

use common\activeRecords\MaterialItemsModel;
use common\activeRecords\UserPrizesModel;
use common\domain\prize\materialItem\MaterialItem;
use common\domain\prize\materialItem\Repository;
use common\domain\prize\Prize;
use common\exception\ExceptionCodes;
use yii\web\IdentityInterface;

class MaterialItemDatabaseRepository implements Repository
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

        return MaterialItem::fromStorage($identity, $model, MaterialItemsModel::findOne(['id' => $model->material_item_id]));
    }

    /**
     * @inheritDoc
     */
    public function save(MaterialItem $materialItem): int
    {
        if (null !== $materialItem->getId()) {
            $userPrizesModel = UserPrizesModel::findOne(['id' => $materialItem->getId()]);
        }
        $userPrizesModel = $materialItem->toStorage($userPrizesModel ?? new UserPrizesModel());

        $transaction = UserPrizesModel::getDb()->beginTransaction();
        try {
            $userPrizesModel->save();
            $materialItemModel = $materialItem->materialItemToStorage(MaterialItemsModel::findOne(['id' => $userPrizesModel->material_item_id]));
            $materialItemModel->save();

            $transaction->commit();
        } catch(\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch(\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }

        return $userPrizesModel->getId();
    }

    /**
     * @inheritDoc
     */
    public function createNew(IdentityInterface $identity, int $materialItemId): MaterialItem
    {
        $materialItemModel = MaterialItemsModel::findOne(['id' => $materialItemId, 'status' => MaterialItemsModel::AVAILABLE_FOR_RAFFLING]);

        if (null === $materialItemModel) {
            throw new \RuntimeException('Not found material item model for user_id #' . $identity->getId() .
                ' and id #' . $materialItemId, ExceptionCodes::NOT_FOUND_MATERIAL_ITEM_MODEL);
        }

        return MaterialItem::generateNewInstance($identity, $materialItemModel);
    }
}