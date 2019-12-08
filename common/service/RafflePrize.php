<?php

namespace common\service;

use common\domain\prize\money\Money;
use common\domain\prize\money\Repository as MoneyRepository;
use common\domain\prize\Prize;
use common\repository\BonusPointsDatabaseRepository;
use yii\web\IdentityInterface;

class RafflePrize
{
    /** @var MoneyRepository */
    private $moneyRepository;

    /** @var BonusPointsDatabaseRepository */
    private $bonusPointsDatabaseRepository;

    public function __construct(
        MoneyRepository $moneyRepository,
        BonusPointsDatabaseRepository $bonusPointsDatabaseRepository
    ) {
        $this->moneyRepository = $moneyRepository;
        $this->bonusPointsDatabaseRepository = $bonusPointsDatabaseRepository;
    }

    /**
     * @param IdentityInterface $identity
     * @return Prize
     * @throws \Throwable
     */
    public function generate(IdentityInterface $identity): Prize
    {
        //todo delete- this is only for test
        return $this->moneyRepository->createNew($identity, random_int(1, 20));
    }

    public function save(Money $prize): void
    {
        //todo delete- this is only for test
        $this->moneyRepository->save($prize);
    }
}