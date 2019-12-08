<?php

namespace common\domain\prize\bonusPoints;

use common\domain\prize\Prize;
use yii\web\IdentityInterface;

interface Repository
{
    /**
     * @param IdentityInterface $identity
     * @param int $id
     * @return BonusPoints
     */
    public function getById(IdentityInterface $identity, int $id): Prize;

    /**
     * @param BonusPoints $bonusPoints
     * @return int
     */
    public function save(BonusPoints $bonusPoints): int;

    /**
     * @param IdentityInterface $identity
     * @param int $amount
     * @return BonusPoints
     */
    public function createNew(IdentityInterface $identity, int $amount): BonusPoints;
}