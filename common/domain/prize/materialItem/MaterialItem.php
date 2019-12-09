<?php

namespace common\domain\prize\materialItem;

use common\activeRecords\MaterialItemsModel;
use common\activeRecords\UserPrizesModel;
use common\domain\prize\Prize;
use common\domain\prize\Statuses;
use common\exception\ExceptionCodes;
use yii\web\IdentityInterface;

class MaterialItem implements Prize
{
    private const MATERIAL_ITEM_AMOUNT = 1;
    private const TYPE_ID = Prize::MATERIAL_ITEM;

    /** @var IdentityInterface */
    private $identity;

    /** @var int */
    private $materialItemId;

    /** @var string */
    private $materialItemName;

    /** @var int */
    private $id;

    /** @var int */
    private $status;

    /** @var int */
    private $materialItemStatus;

    private function __construct(
        IdentityInterface $identity,
        ?int $id,
        int $materialItemId,
        string $materialItemName,
        int $status = Statuses::UNDEFINED,
        int $materialItemStatus = MaterialItemsModel::AVAILABLE_FOR_RAFFLING
    ) {
        $this->identity = $identity;
        $this->id = $id;
        $this->materialItemId = $materialItemId;
        $this->materialItemName = $materialItemName;
        $this->status = $status;
        $this->materialItemStatus = $materialItemStatus;
    }

    /**
     * {@inheritdoc}
     */
    public function apply(): void
    {
        $this->checkStatus();
        $this->status = Statuses::APPLIED;
    }

    /**
     * {@inheritdoc}
     */
    public function decline(): void
    {
        $this->checkStatus();
        $this->status = Statuses::DECLINED;
        $this->materialItemStatus = 0;
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

        return new self($identity, $prizeModel->getId(), $materialItemModel->getId(), $materialItemModel->getName(), $prizeModel->getStatus(), $materialItemModel->status);
    }

    /**
     * {@inheritdoc}
     */
    public function toStorage(UserPrizesModel $record): UserPrizesModel
    {
        $record->prize_amount = self::MATERIAL_ITEM_AMOUNT;
        $record->user_id = $this->identity->getId();
        $record->prize_type = self::TYPE_ID;
        $record->material_item_id = $this->materialItemId;
        $record->prize_status = $this->status;
        if (null !== $this->id) {
            $record->id = $this->id;
        }

        return $record;
    }

    public function materialItemToStorage(MaterialItemsModel $record): MaterialItemsModel
    {
        $record->id = $this->materialItemId;
        $record->name = $this->materialItemName;
        $record->status = $this->status === Statuses::APPLIED ? 1 : 0;

        return $record;
    }

    /**
     * @param IdentityInterface $identity
     * @param MaterialItemsModel $materialItemModel
     * @return static
     */
    public static function generateNewInstance(IdentityInterface $identity, MaterialItemsModel $materialItemModel): self
    {
        if (MaterialItemsModel::AVAILABLE_FOR_RAFFLING !== $materialItemModel->getStatus()) {
            throw new \RuntimeException('Creating new instance available only for NEW ' . MaterialItemsModel::class, ExceptionCodes::INVALID_STATUS_OF_MATERIAL_ITEM_MODEL);
        }

        return new self($identity, null, $materialItemModel->getId(), $materialItemModel->getName());
    }

    /**
     * @inheritDoc
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    public function markAsSentByPost(): void
    {
        $this->status = Statuses::SENT_BY_POST;
    }

    private function checkStatus(): void
    {
        if (Statuses::UNDEFINED !== $this->status) {
            throw new \RuntimeException('Model #' . $this->id . ' was processed before', ExceptionCodes::PRIZE_WAS_PROCESSED_BEFORE);
        }
    }
}