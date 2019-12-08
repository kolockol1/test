<?php

namespace common\test\domain\prize\money;

use common\activeRecords\UserPrizesModel;
use common\domain\prize\money\Money;
use common\exception\ExceptionCodes;
use common\models\User;
use common\test\MockGenerator;
use DeepCopy\Reflection\ReflectionHelper;
use PHPUnit\Framework\TestCase;

class MoneyTest extends TestCase
{
    /**
     * @var User|\PHPUnit\Framework\MockObject\MockObject
     */
    private $identity;
    /**
     * @var MockGenerator
     */
    private $mockGenerator;

    protected function setUp()
    {
        parent::setUp();
        $this->identity = $this->getMockBuilder(User::class)->disableOriginalConstructor()->getMock();
        $this->mockGenerator = new MockGenerator();
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
    public function testFromStorage(int $amount, ?int $id, int $expectedAmount, ?int $expectedId)
    {
        $model = $this->mockGenerator->userPrizesModel($amount, $id, 1);

        $prize = Money::fromStorage($this->identity, $model);

        $this->assertEquals($expectedAmount, $prize->getAmount());
        $reflectionProperty = ReflectionHelper::getProperty($prize, 'id');
        $reflectionProperty->setAccessible(true);
        $this->assertEquals($expectedId, $reflectionProperty->getValue($prize));
    }

    public function testFromStorageWithException()
    {
        $model = $this->mockGenerator->userPrizesModel(1, 1, 2); //wrong type  for Money

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionCode(ExceptionCodes::INVALID_TYPE_FOR_PRIZE);
        Money::fromStorage($this->identity, $model);
    }
}