<?php

namespace common\test;

use common\activeRecords\MaterialItemsModel;
use common\activeRecords\MoneyConfiguration;
use common\activeRecords\UserPrizesModel;
use common\domain\prize\Statuses;
use PHPUnit\Framework\TestCase;

class MockGenerator extends TestCase
{
    /**
     * @param int $amount
     * @param int|null $id
     * @param int $typeId
     * @param int $status
     * @return UserPrizesModel
     */
    public function userPrizesModel(int $amount, ?int $id, int $typeId, int $status = Statuses::APPLIED): UserPrizesModel
    {
        $model = $this->getMockBuilder(UserPrizesModel::class)->setMethods(['getPrizeAmount', 'getId', 'attributes', 'save', 'getTypeId', 'getStatus'])->getMock();
        $model->method('getPrizeAmount')->willReturn($amount);
        $model->method('getId')->willReturn($id);
        $model->method('attributes')->willReturn(['id', 'user_id', 'date_create', 'prize_type', 'prize_amount', 'prize_status']);
        $model->method('save')->willReturn(true);
        $model->method('getTypeId')->willReturn($typeId);
        $model->method('getStatus')->willReturn($status);

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

    public function moneyConfigurationModel(float $conversionRatio = 2.5): MoneyConfiguration
    {
        $model = $this->getMockBuilder(MoneyConfiguration::class)->setMethods(['getConversionRatio','attributes', 'save'])->getMock();
        $model->method('getConversionRatio')->willReturn($conversionRatio);
        $model->method('attributes')->willReturn(['id', 'status', 'name']);
        $model->method('save')->willReturn(true);

        return $model;
    }
}