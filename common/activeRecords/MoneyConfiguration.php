<?php

namespace common\activeRecords;

use Yii;

/**
 * This is the model class for table "money_configuration".
 *
 * @property int $id
 * @property int $left_amount
 * @property int $min_limit
 * @property int $max_limit
 * @property float $conversion_ratio money amount will be multiplied on that value on conversion
 */
class MoneyConfiguration extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'money_configuration';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['left_amount', 'min_limit', 'max_limit', 'conversion_ratio'], 'required'],
            [['left_amount', 'min_limit', 'max_limit'], 'default', 'value' => null],
            [['left_amount', 'min_limit', 'max_limit'], 'integer'],
            [['conversion_ratio'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'left_amount' => 'Left Amount',
            'min_limit' => 'Min Limit',
            'max_limit' => 'Max Limit',
            'conversion_ratio' => 'Conversion Ratio',
        ];
    }

    public static function getSingle(): ?self
    {
        return self::findOne(['id' => 1]); //todo change, now I don't have enough time((((
    }

    /**
     * @return float
     */
    public function getConversionRatio(): float
    {
        return $this->conversion_ratio;
    }
}
