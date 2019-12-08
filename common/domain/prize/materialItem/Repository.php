<?php

namespace common\domain\prize\materialItem;

use common\domain\prize\Prize;
use yii\web\IdentityInterface;

interface Repository
{
    /**
     * @param IdentityInterface $identity
     * @param int $id
     * @return MaterialItem
     */
    public function getById(IdentityInterface $identity, int $id): Prize;

    /**
     * @param MaterialItem $materialItem
     * @return int
     */
    public function save(MaterialItem $materialItem): int;

    /**
     * @param IdentityInterface $identity
     * @param int $materialItemId
     * @return MaterialItem
     */
    public function createNew(IdentityInterface $identity, int $materialItemId): MaterialItem;
}