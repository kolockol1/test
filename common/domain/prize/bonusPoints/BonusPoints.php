<?php

namespace common\domain\prize\bonusPoints;

use common\activeRecords\UserPrizesModel;
use common\domain\prize\Prize;
use common\exception\ExceptionCodes;
use yii\web\IdentityInterface;

class BonusPoints implements Prize
{
    private const TYPE_ID = 2;

    /** @var IdentityInterface */
    private $identity;

    /** @var int */
    private $amount;

    /** @var int */
    private $id;

    private function __construct(IdentityInterface $identity, int $amount, ?int $id)
    {
        $this->identity = $identity;
        $this->amount = $amount;
        $this->id = $id;
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
        return $this->amount;
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription(): string
    {
        return 'Bonus points as prize';
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
            throw new \RuntimeException('Type #' . $model->getTypeId() . 'is not supported by Bonus Points', ExceptionCodes::INVALID_TYPE_FOR_PRIZE);
        }

        return new self($identity, $model->getPrizeAmount(), $model->getId());
    }

    /**
     * {@inheritdoc}
     */
    public function toStorage(UserPrizesModel $record): UserPrizesModel
    {
        $record->prize_amount = $this->amount;
        $record->id = $this->id;
        $record->user_id = $this->identity->getId();
        $record->prize_type = self::TYPE_ID;

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
}