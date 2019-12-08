<?php

namespace common\domain\prize;

use common\activeRecords\UserPrizesModel;
use yii\web\IdentityInterface;

interface Prize
{
    public const MONEY = 1;
    public const BONUS_POINTS = 2;
    public const MATERIAL_ITEM = 3;

    public function apply(): void;

    public function decline(): void;

    /**
     * @return int
     */
    public function getAmount(): int;

    /**
     * @return string
     */
    public function getDescription(): string;

    /**
     * @return iterable
     */
    public function getSupportedActions(): iterable;

    /**
     * @param IdentityInterface $identity
     * @param UserPrizesModel $model
     * @return static
     */
    public static function fromStorage(IdentityInterface $identity, UserPrizesModel $model): self;

    /**
     * @param UserPrizesModel $model
     * @return UserPrizesModel
     */
    public function toStorage(UserPrizesModel $model): UserPrizesModel;

    /**
     * @return int
     */
    public function getId(): ?int;
}