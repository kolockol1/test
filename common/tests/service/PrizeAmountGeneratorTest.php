<?php

namespace common\tests\service;


use common\service\PrizeAmountGenerator;
use PHPUnit\Framework\TestCase;

class PrizeAmountGeneratorTest extends TestCase
{

    /**
     * @var PrizeAmountGenerator
     */
    private $prizeAmountGenerator;

    public function generateMoneyAmountDataProvider()
    {
        return [
            'left amount larger than all' => [
                'leftAmount' => 55,
                'minValue' => 11,
                'maxValue' => 54,
                'expectedMinValue' => 11,
                'expectedMaxValue' => 54,
            ],
            'left amount between min and max' => [
                'leftAmount' => 55,
                'minValue' => 11,
                'maxValue' => 600,
                'expectedMinValue' => 11,
                'expectedMaxValue' => 55,
            ],
            'left amount lower min and max' => [
                'leftAmount' => 0.56,
                'minValue' => 11,
                'maxValue' => 55,
                'expectedMinValue' => 0,
                'expectedMaxValue' => 0,
            ],
        ];
    }

    protected function setUp()
    {
        parent::setUp();
        $this->prizeAmountGenerator = new PrizeAmountGenerator();
    }

    /**
     * @dataProvider generateMoneyAmountDataProvider
     * @param float $leftAmount
     * @param int $minValue
     * @param int $maxValue
     * @param int $expectedMinValue
     * @param int $expectedMaxValue
     */
    public function testGenerateMoneyAmount(float $leftAmount, int $minValue, int $maxValue, int $expectedMinValue, int $expectedMaxValue)
    {
        $moneyAmount = $this->prizeAmountGenerator->generateMoneyAmount($leftAmount, $minValue, $maxValue);

        $this->assertTrue($moneyAmount >= $expectedMinValue && $moneyAmount <= $expectedMaxValue);
    }
}
