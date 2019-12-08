<?php

namespace common\domain\prize\money;

use common\activeRecords\UserPrizesModel;
use common\domain\prize\Prize;
use common\domain\prize\Statuses;
use common\exception\ExceptionCodes;
use yii\web\IdentityInterface;

class Money implements Prize
{
    private const TYPE_ID = Prize::MONEY;

    /** @var IdentityInterface */
    private $identity;

    /** @var int */
    private $amount;

    /** @var int */
    private $id;

    /** @var int */
    private $status;

    private function __construct(IdentityInterface $identity, int $amount, ?int $id, int $status = Statuses::UNDEFINED)
    {
        $this->identity = $identity;
        $this->amount = $amount;
        $this->id = $id;
        $this->status = $status;
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
    }

    /**
     * {@inheritdoc}
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription(): string
    {
        return 'Real money as prize in quantity #' . $this->amount;
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
    public static function fromStorage(IdentityInterface $identity, UserPrizesModel $model): Prize
    {
        if (self::TYPE_ID !== $model->getTypeId()) {
            throw new \RuntimeException('Type #' . $model->getTypeId() . 'is not supported by Money', ExceptionCodes::INVALID_TYPE_FOR_PRIZE);
        }

        return new self($identity, $model->getPrizeAmount(), $model->getId(), $model->getStatus());
    }

    /**
     * {@inheritdoc}
     */
    public function toStorage(UserPrizesModel $record): UserPrizesModel
    {
        $record->prize_amount = $this->amount;
        $record->user_id = $this->identity->getId();
        $record->prize_type = self::TYPE_ID;
        $record->prize_status = $this->status;
        if (null !== $this->id) {
            $record->id = $this->id;
        }

        return $record;
    }

    /**
     * @param IdentityInterface $identity
     * @param int $amount
     * @return static
     */
    public static function generateNewInstance(IdentityInterface $identity, int $amount): self
    {
        return new self($identity, $amount, null);
    }

    /**
     * @inheritDoc
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    private function checkStatus(): void
    {
        if (Statuses::UNDEFINED !== $this->status) {
            throw new \RuntimeException('Model #' . $this->id . ' was processed before', ExceptionCodes::PRIZE_WAS_PROCESSED_BEFORE);
        }
    }
}