<?php

namespace common\domain\prize\money;

use common\domain\prize\Prize;
use yii\web\IdentityInterface;

interface Repository
{
    /**
     * @param IdentityInterface $identity
     * @param int $id
     * @return Money
     */
    public function getById(IdentityInterface $identity, int $id): Prize;

    /**
     * @param Money $money
     */
    public function save(Money $money): void;

    /**
     * @param IdentityInterface $identity
     * @param int $amount
     * @return Money
     */
    public function createNew(IdentityInterface $identity, int $amount): Money;
}