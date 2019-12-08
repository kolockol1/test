<?php

namespace common\service;

use common\domain\prize\money\Money;
use common\domain\prize\money\Repository as MoneyRepository;
use common\domain\prize\Prize;
use common\domain\prize\bonusPoints\Repository as BonusPointsRepository;
use yii\web\IdentityInterface;

class RafflePrize
{
    /** @var MoneyRepository */
    private $moneyRepository;

    /** @var BonusPointsRepository */
    private $bonusPointsRepository;

    public function __construct(
        MoneyRepository $moneyRepository,
        BonusPointsRepository $bonusPointsDatabaseRepository
    ) {
        $this->moneyRepository = $moneyRepository;
        $this->bonusPointsRepository = $bonusPointsDatabaseRepository;
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

    /**
     * @param Money $prize
     * @return int
     */
    public function save(Money $prize): int
    {
        //todo delete- this is only for test
        return $this->moneyRepository->save($prize);
    }

    /**
     * @param IdentityInterface $identity
     * @param int $prizeId
     */
    public function apply(IdentityInterface $identity, int $prizeId): void
    {
        $prize = $this->moneyRepository->getById($identity, $prizeId);
        $prize->apply();

        $this->moneyRepository->save($prize);
    }

    /**
     * @param IdentityInterface $identity
     * @param int $prizeId
     */
    public function decline(IdentityInterface $identity, int $prizeId): void
    {
        $prize = $this->moneyRepository->getById($identity, $prizeId);
        $prize->decline();

        $this->moneyRepository->save($prize);
    }
}