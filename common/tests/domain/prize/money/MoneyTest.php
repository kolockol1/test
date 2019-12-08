<?php

namespace common\test\domain\prize\money;

use common\activeRecords\UserPrizesModel;
use common\domain\prize\money\Money;
use common\models\User;
use DeepCopy\Reflection\ReflectionHelper;
use PHPUnit\Framework\TestCase;

class MoneyTest extends TestCase
{
    /**
     * @var User|\PHPUnit\Framework\MockObject\MockObject
     */
    private $identity;

    protected function setUp()
    {
        parent::setUp();
        $this->identity = $this->getMockBuilder(User::class)->disableOriginalConstructor()->getMock();
    }

    public function fromStorageDataProvider()
    {
        return [
            'model, saved previously' => [
                'amount' => 55,
                'id' => 11,
                'expectedAmount' => 55,
                'expectedId' => 11,
            ],
            'model, which wasn\'t saved before' => [
                'amount' => 55,
                'id' => null,
                'expectedAmount' => 55,
                'expectedId' => null,
            ]
        ];
    }

    /**
     * @dataProvider fromStorageDataProvider
     * @param int $amount
     * @param int|null $id
     * @param int $expectedAmount
     * @param int|null $expectedId
     * @throws \DeepCopy\Exception\PropertyException
     * @throws \ReflectionException
     */
    public function testSave(int $amount, ?int $id, int $expectedAmount, ?int $expectedId)
    {
        $model = $this->getMockBuilder(UserPrizesModel::class)->setMethods(['getPrizeAmount', 'getId', 'attributes', 'save'])->getMock();
        $model->method('getPrizeAmount')->willReturn($amount);
        $model->method('getId')->willReturn($id);
        $model->method('attributes')->willReturn(['id', 'user_id', 'date_create', 'prize_type', 'prize_amount', 'prize_status']);
        $model->method('save')->willReturn(true);

        $prize = Money::fromStorage($this->identity, $model);

        $this->assertEquals($expectedAmount, $prize->getAmount());
        $reflectionProperty = ReflectionHelper::getProperty($prize, 'id');
        $reflectionProperty->setAccessible(true);
        $this->assertEquals($expectedId, $reflectionProperty->getValue($prize));
    }
}