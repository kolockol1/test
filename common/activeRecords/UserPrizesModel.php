<?php

namespace common\activeRecords;

/**
 * @property int $id
 * @property int $user_id
 * @property string $date_create
 * @property int $prize_type
 * @property float $prize_amount
 * @property int $prize_status
 */
class UserPrizesModel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_prizes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'prize_type', 'prize_amount', 'prize_status'], 'required'],
            [['user_id', 'prize_type', 'prize_status'], 'default', 'value' => null],
            [['user_id', 'prize_type', 'prize_status'], 'integer'],
            [['prize_amount'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'date_create' => 'Date Create',
            'prize_type' => 'Prize Type',
            'prize_amount' => 'Prize Amount',
            'prize_status' => 'Prize Status',
        ];
    }

    public function getPrizeAmount(): ?int
    {
        return $this->prize_amount;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeId(): int
    {
        return $this->prize_type;
    }

    public function getStatus(): int
    {
        return $this->prize_status;
    }
}
