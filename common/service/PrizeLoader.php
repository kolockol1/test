<?php

namespace common\service;

use common\activeRecords\UserPrizesModel;
use common\domain\prize\bonusPoints\Repository as BonusPointsRepository;
use common\domain\prize\materialItem\Repository as MaterialItemRepository;
use common\domain\prize\money\Repository as MoneyRepository;
use common\domain\prize\Prize;
use yii\web\IdentityInterface;

class PrizeLoader
{
    /** @var MoneyRepository */
    private $moneyRepository;

    /** @var BonusPointsRepository */
    private $bonusPointsRepository;

    /** @var MaterialItemRepository */
    private $materialItemRepository;

    public function __construct(
        MoneyRepository $moneyRepository,
        BonusPointsRepository $bonusPointsDatabaseRepository,
        MaterialItemRepository $materialItemRepository
    ) {
        $this->moneyRepository = $moneyRepository;
        $this->bonusPointsRepository = $bonusPointsDatabaseRepository;
        $this->materialItemRepository = $materialItemRepository;
    }

    /**
     * @param IdentityInterface $identity
     * @return Prize[]
     * @throws \Throwable
     */
    public function loadAll(IdentityInterface $identity): iterable
    {
        $prizes = [];
        $models = UserPrizesModel::findAll(['user_id' => $identity->getId(), 'prize_status' => [1, 3]]);

        foreach ($models as $model) {
            switch ($model->prize_type) { //todo this is awful, do something
                case 1:
                    $prizes[] = $this->moneyRepository->getById($identity, $model->getId());
                    break;
                case 2:
                    $prizes[] = $this->bonusPointsRepository->getById($identity, $model->getId());
                    break;
                case 3:
                    $prizes[] = $this->materialItemRepository->getById($identity, $model->getId());
                    break;
            }
        }

        return $prizes;
    }
}