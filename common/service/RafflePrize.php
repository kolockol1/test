<?php

namespace common\service;

use common\activeRecords\BonusPointsConfiguration;
use common\activeRecords\MaterialItemsModel;
use common\activeRecords\MoneyConfiguration;
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
    private const DEFAULT_MIN_POINTS_LIMIT_AMOUNT = 2;
    private const DEFAULT_MAX_POINTS_LIMIT_AMOUNT = 100;

    /** @var MoneyRepository */
    private $moneyRepository;

    /** @var BonusPointsRepository */
    private $bonusPointsRepository;

    /** @var MaterialItemRepository */
    private $materialItemRepository;

    /** @var PrizeAmountGenerator */
    private $prizeAmountGenerator;
    /**
     * @var PrizeConverter
     */
    private $prizeConverter;
    /**
     * @var MoneyWithdrawal
     */
    private $moneyWithdrawal;

    /**
     * @param MoneyRepository $moneyRepository
     * @param BonusPointsRepository $bonusPointsRepository
     * @param MaterialItemRepository $materialItemRepository
     * @param PrizeAmountGenerator $prizeAmountGenerator
     * @param PrizeConverter $prizeConverter
     * @param MoneyWithdrawal $moneyWithdrawal
     */
    public function __construct(
        MoneyRepository $moneyRepository,
        BonusPointsRepository $bonusPointsRepository,
        MaterialItemRepository $materialItemRepository,
        PrizeAmountGenerator $prizeAmountGenerator,
        PrizeConverter $prizeConverter,
        MoneyWithdrawal $moneyWithdrawal
    ) {
        $this->moneyRepository = $moneyRepository;
        $this->bonusPointsRepository = $bonusPointsRepository;
        $this->materialItemRepository = $materialItemRepository;
        $this->prizeAmountGenerator = $prizeAmountGenerator;
        $this->prizeConverter = $prizeConverter;
        $this->moneyWithdrawal = $moneyWithdrawal;
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
        $moneyConfiguration = MoneyConfiguration::getSingle();
        $prizeType = random_int(1, 3);
        $prize = null;

        if (Prize::MATERIAL_ITEM === $prizeType && null !== $materialItemsModel) {
            $prize = $this->materialItemRepository->createNew($identity, $materialItemsModel->getId());
        } elseif (Prize::MONEY === $prizeType && null !== $moneyConfiguration) {
            $moneyAmount = $this->prizeAmountGenerator->generateMoneyAmount(
                $moneyConfiguration->left_amount,
                $moneyConfiguration->min_limit,
                $moneyConfiguration->max_limit
            );

            if (0 !== $moneyAmount) {
                $prize = $this->moneyRepository->createNew($identity, $moneyAmount);
            }
        }
        if (null === $prize) {
            $pointsConfiguration = BonusPointsConfiguration::getSingle();
            $pointsAmount = $this->prizeAmountGenerator->generatePointsAmount(
                $pointsConfiguration->min_limit ?? self::DEFAULT_MIN_POINTS_LIMIT_AMOUNT,
                $pointsConfiguration->max_limit ?? self::DEFAULT_MAX_POINTS_LIMIT_AMOUNT
            );

            $prize = $this->bonusPointsRepository->createNew($identity, $pointsAmount);
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

    public function convert(IdentityInterface $identity, int $prizeId): void
    {
        $prize = $this->getPrizeFromAny($identity, $prizeId);
        $convertedPrize = $this->prizeConverter->convert($identity, $prize, MoneyConfiguration::getSingle());

        $repository = $this->getRepository($convertedPrize);
        $repository->save($convertedPrize);
    }

    public function moneyWithdrawal(IdentityInterface $identity, int $prizeId): void
    {
        $prize = $this->getPrizeFromAny($identity, $prizeId);
        $this->moneyWithdrawal->withdrawal($prize);

        $repository = $this->getRepository($prize);
        $repository->save($prize);
    }

    public function sendByPost(IdentityInterface $identity, int $prizeId): void
    {
        $prize = $this->getPrizeFromAny($identity, $prizeId);
        if (false === $prize instanceof MaterialItem) {
            throw new \RuntimeException('Unsupported type of Prize for sending by Post');
        }

        $prize->markAsSentByPost();

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