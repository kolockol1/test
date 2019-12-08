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

//    /**
//     * {@inheritdoc}
//     */
//    public function getById(IdentityInterface $identity, int $id): Prize
//    {
//        $model = UserPrizesModel::findOne(['id' => $id, 'user_id' => $identity->getId()]);
//
//        if ($model === null) {
//            throw new \RuntimeException('Not found prize model for user_id #' . $identity->getId() .
//                ' and id #' . $id, ExceptionCodes::NOT_FOUND_PRIZE_MODEL);
//        }
//
//        return Money::fromStorage($identity, $model);
//    }
//
//    /**
//     * {@inheritdoc}
//     */
//    public function save(Money $money): void
//    {
//        $model = $money->toStorage(new UserPrizesModel());
//        $model->save();
//    }
//
//    /**
//     * {@inheritdoc}
//     */
//    public function createNew(IdentityInterface $identity, int $amount): Money
//    {
//        return Money::generateNewInstance($identity, $amount);
//    }
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

        return MaterialItem::fromStorage($identity, $model);
    }

    /**
     * @inheritDoc
     */
    public function save(MaterialItem $materialItem): void
    {
        $userPrizesModel = $materialItem->toStorage(new UserPrizesModel());
        $userPrizesModel->save();

        $materialItemModel = $materialItem->materialItemToStorage(new MaterialItemsModel());
        $materialItemModel->save();
    }

    /**
     * @inheritDoc
     */
    public function createNew(IdentityInterface $identity, int $materialItemId): MaterialItem
    {
        $materialItemModel = MaterialItemsModel::findOne(['id' => $materialItemId]);

        if (null === $materialItemModel) {
            throw new \RuntimeException('Not found material item model for user_id #' . $identity->getId() .
                ' and id #' . $materialItemId, ExceptionCodes::NOT_FOUND_MATERIAL_ITEM_MODEL);
        }

        return MaterialItem::generateNewInstance($identity, $materialItemModel);
    }
}