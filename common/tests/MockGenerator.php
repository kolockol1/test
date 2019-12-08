<?php

namespace common\test;

use common\activeRecords\UserPrizesModel;
use PHPUnit\Framework\TestCase;

class MockGenerator extends TestCase
{
    /**
     * @param int $amount
     * @param int|null $id
     * @param int $typeId
     * @return UserPrizesModel
     */
    public function userPrizesModel(int $amount, ?int $id, int $typeId): UserPrizesModel
    {
        $model = $this->getMockBuilder(UserPrizesModel::class)->setMethods(['getPrizeAmount', 'getId', 'attributes', 'save', 'getTypeId'])->getMock();
        $model->method('getPrizeAmount')->willReturn($amount);
        $model->method('getId')->willReturn($id);
        $model->method('attributes')->willReturn(['id', 'user_id', 'date_create', 'prize_type', 'prize_amount', 'prize_status']);
        $model->method('save')->willReturn(true);
        $model->method('getTypeId')->willReturn($typeId);

        return $model;
    }
}