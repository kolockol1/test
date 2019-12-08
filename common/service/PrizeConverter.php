<?php

namespace common\service;

use common\activeRecords\MoneyConfiguration;
use common\domain\prize\bonusPoints\BonusPoints;
use common\domain\prize\money\Money;
use common\domain\prize\Prize;
use yii\web\IdentityInterface;

class PrizeConverter
{
    /**
     * @param IdentityInterface $identity
     * @param Prize $from
     * @param MoneyConfiguration|null $moneyConfiguration
     * @return Prize
     */
    public function convert(IdentityInterface $identity, Prize $from, ?MoneyConfiguration $moneyConfiguration): Prize
    {
        if (false === $from instanceof Money) {
            throw new \RuntimeException('Doesn\'t support such conversion');
        }

        if (null === $moneyConfiguration || !is_numeric($moneyConfiguration->getConversionRatio())) {
            throw new \RuntimeException('No valid configuration for conversion');
        }

        return BonusPoints::convertFromMoneyType(
            $identity,
            $from->getAmount() * $moneyConfiguration->getConversionRatio(),
            $from->getId()
        );
    }
}