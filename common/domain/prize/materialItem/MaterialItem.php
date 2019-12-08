<?php

namespace common\domain\prize\materialItem;

use common\activeRecords\MaterialItemsModel;
use common\activeRecords\UserPrizesModel;
use common\domain\prize\Prize;
use common\exception\ExceptionCodes;
use yii\web\IdentityInterface;

class MaterialItem implements Prize
{
    private const MATERIAL_ITEM_AMOUNT = 1;
    private const TYPE_ID = 3;

    /** @var IdentityInterface */
    private $identity;

    /** @var int */
    private $materialItemId;

    /** @var string */
    private $materialItemName;

    /** @var int */
    private $id;

    private function __construct(
        IdentityInterface $identity,
        ?int $id,
        int $materialItemId,
        string $materialItemName
    ) {
        $this->identity = $identity;
        $this->id = $id;
        $this->materialItemId = $materialItemId;
        $this->materialItemName = $materialItemName;
    }

    /**
     * {@inheritdoc}
     */
    public function apply(): void
    {
        // TODO: Implement apply() method.
    }

    /**
     * {@inheritdoc}
     */
    public function decline(): void
    {
        // TODO: Implement decline() method.
    }

    /**
     * {@inheritdoc}
     */
    public function getAmount(): int
    {
        return self::MATERIAL_ITEM_AMOUNT;
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription(): string
    {
        return 'Material Item as prize with name #' . $this->materialItemName;
    }

    /**
     * {@inheritdoc}
     */
    public function getSupportedActions(): iterable
    {
        // TODO: Implement getSupportedActions() method.
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public static function fromStorage(IdentityInterface $identity, UserPrizesModel $prizeModel, MaterialItemsModel $materialItemModel = null): Prize
    {
        if (self::TYPE_ID !== $prizeModel->getTypeId()) {
            throw new \RuntimeException('Type #' . $prizeModel->getTypeId() . 'is not supported by Material Item', ExceptionCodes::INVALID_TYPE_FOR_PRIZE);
        }
        if (null === $materialItemModel) {
            throw new \RuntimeException('For creating Material Item you have to send ' . MaterialItemsModel::class . ' model', ExceptionCodes::MATERIAL_ITEM_MODEL_MUST_BE_DEFINED);
        }

        return new self($identity, $prizeModel->getId(), $materialItemModel->getId(), $materialItemModel->getName());
    }

    /**
     * {@inheritdoc}
     */
    public function toStorage(UserPrizesModel $record): UserPrizesModel
    {
        $record->prize_amount = self::MATERIAL_ITEM_AMOUNT;
        $record->id = $this->id;
        $record->user_id = $this->identity->getId();
        $record->prize_type = self::TYPE_ID;

        return $record;
    }

    public function materialItemToStorage(MaterialItemsModel $record): MaterialItemsModel
    {
        $record->id = $this->materialItemId;
        $record->name = $this->materialItemName;
        $record->status = 0 === $record->status ? 1 : 2;//todo move move work with statuses to MaterialItemStatuses service

        return $record;
    }

    /**
     * @param IdentityInterface $identity
     * @param MaterialItemsModel $materialItemModel
     * @return static
     */
    public static function generateNewInstance(IdentityInterface $identity, MaterialItemsModel $materialItemModel): self
    {
        if (0 !== $materialItemModel->getStatus()) { //todo del 0 and move move work with statuses to MaterialItemStatuses service
            throw new \RuntimeException('Creating new instance available only for NEW ' . MaterialItemsModel::class, ExceptionCodes::INVALID_STATUS_OF_MATERIAL_ITEM_MODEL);
        }

        return new self($identity, self::MATERIAL_ITEM_AMOUNT, $materialItemModel->getId(), $materialItemModel->getName());
    }
}