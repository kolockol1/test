<?php


namespace common\service;


class PrizeAmountGenerator
{

    public function generateMoneyAmount(float $leftAmount, int $minValue, int $maxValue): int
    {
        $max = $maxValue > $leftAmount ? $leftAmount : $maxValue;
        $min = $minValue > $leftAmount ? 0 : $minValue;

        return random_int($min, $max);
    }

    public function generatePointsAmount(int $minValue, int $maxValue): int
    {
        return random_int($minValue, $maxValue);
    }
}