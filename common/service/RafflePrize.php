<?php

namespace common\service;

use common\activeRecords\MaterialItemsModel;
use common\domain\prize\bonusPoints\BonusPoints;
use common\domain\prize\materialItem\MaterialItem;
use common\domain\prize\materialItem\Repository as MaterialItemRepository;
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

    /** @var MaterialItemRepository */
    private $materialItemRepository;

    public function __construct(
        MoneyRepository $moneyRepository,
        BonusPointsRepository $bonusPointsRepository,
        MaterialItemRepository $materialItemRepository
    ) {
        $this->moneyRepository = $moneyRepository;
        $this->bonusPointsRepository = $bonusPointsRepository;
        $this->materialItemRepository = $materialItemRepository;
    }

    /**
     * @param IdentityInterface $identity
     * @return Prize
     * @throws \Throwable
     */
    public function generate(IdentityInterface $identity): Prize
    {
        $materialItemsModels = MaterialItemsModel::findAll(['status' => MaterialItemsModel::AVAILABLE_FOR_RAFFLING]);
        shuffle($materialItemsModels);
        $materialItemsModel = array_shift($materialItemsModels);

        $prizeType = 3;//random_int(1, 3);

        if (Prize::MATERIAL_ITEM === $prizeType && null !== $materialItemsModel) {
            $prize = $this->materialItemRepository->createNew($identity, $materialItemsModel->getId());
        } elseif (Prize::MONEY === $prizeType) {
            $prize = $this->moneyRepository->createNew($identity, random_int(1, 20));
        } else {
            $prize = $this->bonusPointsRepository->createNew($identity, random_int(1, 200));
        }

        return $prize;
    }

    /**
     * @param Prize $prize
     * @return int
     */
    public function save(Prize $prize): int
    {
        $repository = $this->getRepository($prize);

        return $repository->save($prize);
    }

    /**
     * @param IdentityInterface $identity
     * @param int $prizeId
     */
    public function apply(IdentityInterface $identity, int $prizeId): void
    {
        $prize = $this->getPrizeFromAny($identity, $prizeId);
        $prize->apply();

        $repository = $this->getRepository($prize);
        $repository->save($prize);
    }

    /**
     * @param IdentityInterface $identity
     * @param int $prizeId
     */
    public function decline(IdentityInterface $identity, int $prizeId): void
    {
        $prize = $this->getPrizeFromAny($identity, $prizeId);
        $prize->decline();

        $repository = $this->getRepository($prize);
        $repository->save($prize);
    }

    /**
     * @param Prize $prize
     * @return BonusPointsRepository|MaterialItemRepository|MoneyRepository
     */
    private function getRepository(Prize $prize)
    {
        if ($prize instanceof Money) {
            $result = $this->moneyRepository;
        } elseif ($prize instanceof MaterialItem) {
            $result = $this->materialItemRepository;
        } elseif ($prize instanceof BonusPoints) {
            $result = $this->bonusPointsRepository;
        } else {
            throw new \RuntimeException('Unsupported type of Prize');
        }

        return $result;
    }

    /**
     * @param IdentityInterface $identity
     * @param int $prizeId
     * @return Prize
     */
    private function getPrizeFromAny(IdentityInterface $identity, int $prizeId): Prize
    {
        $prize = null;

        foreach ([$this->moneyRepository, $this->materialItemRepository, $this->bonusPointsRepository] as $repository) {
            try {
                $prize = $repository->getById($identity, $prizeId);
            }
            catch (\Exception $exception) {
                continue;
            }
        }

        if ($prize instanceof Prize) {
            return $prize;
        }

        throw new \RuntimeException('Prize #' . $prizeId . ' not found in any repository');
    }
}