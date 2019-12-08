<?php

namespace common\test;

use common\activeRecords\MaterialItemsModel;
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

    /**
     * @param int $id
     * @param string $name
     * @param int $status
     * @return MaterialItemsModel
     */
    public function materialItemsModel(int $id, string $name, int $status): MaterialItemsModel
    {
        $model = $this->getMockBuilder(MaterialItemsModel::class)->setMethods(['getId', 'getName', 'getStatus', 'attributes', 'save'])->getMock();
        $model->method('getId')->willReturn($id);
        $model->method('getName')->willReturn($name);
        $model->method('getStatus')->willReturn($status);
        $model->method('attributes')->willReturn(['id', 'status', 'name']);
        $model->method('save')->willReturn(true);

        return $model;
    }
}