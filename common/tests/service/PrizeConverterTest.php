<?php

namespace common\tests\service;

use common\domain\prize\money\Money;
use common\domain\prize\Statuses;
use common\models\User;
use common\service\PrizeConverter;
use common\test\MockGenerator;
use DeepCopy\Reflection\ReflectionHelper;
use PHPUnit\Framework\TestCase;

class PrizeConverterTest extends TestCase
{
    /**
     * @var User|\PHPUnit\Framework\MockObject\MockObject
     */
    private $identity;
    /**
     * @var PrizeConverter
     */
    private $prizeConverter;
    /**
     * @var MockGenerator
     */
    private $mockGenerator;

    protected function setUp()
    {
        parent::setUp();
        $this->identity = $this->getMockBuilder(User::class)->disableOriginalConstructor()->getMock();
        $this->prizeConverter = new PrizeConverter();
        $this->mockGenerator = new MockGenerator();
    }

    public function testConvert()
    {
        $model = $this->mockGenerator->userPrizesModel(44, 55, 1);
        $prize = Money::fromStorage($this->identity, $model);
        $convertedPrize = $this->prizeConverter->convert(
            $this->identity,
            $prize,
            $this->mockGenerator->moneyConfigurationModel(4)
        );

        $this->assertEquals(55, $convertedPrize->getId());
        $this->assertEquals(44 * 4, $convertedPrize->getAmount());
        $reflectionProperty = ReflectionHelper::getProperty($prize, 'status');
        $reflectionProperty->setAccessible(true);
        $this->assertEquals(Statuses::APPLIED, $reflectionProperty->getValue($prize));
        $reflectionProperty = ReflectionHelper::getProperty($convertedPrize, 'status');
        $reflectionProperty->setAccessible(true);
        $this->assertEquals(Statuses::CONVERTED_TO_POINTS, $reflectionProperty->getValue($convertedPrize));
    }
}
