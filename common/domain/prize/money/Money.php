<?php

namespace common\domain\prize\money;

use common\activeRecords\UserPrizesModel;
use common\domain\prize\Prize;
use yii\web\IdentityInterface;

class Money implements Prize
{
    private const TYPE_ID = 1;

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
        return 'Real money as prize';
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