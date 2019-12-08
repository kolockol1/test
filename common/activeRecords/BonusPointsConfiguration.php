<?php

namespace common\activeRecords;

use Yii;

/**
 * This is the model class for table "bonus_points_configuration".
 *
 * @property int $id
 * @property int $min_limit
 * @property int $max_limit
 */
class BonusPointsConfiguration extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bonus_points_configuration';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['min_limit', 'max_limit'], 'required'],
            [['min_limit', 'max_limit'], 'default', 'value' => null],
            [['min_limit', 'max_limit'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'min_limit' => 'Min Limit',
            'max_limit' => 'Max Limit',
        ];
    }

    public static function getSingle(): ?self
    {
        return self::findOne(['id' => 1]);//todo change, now I don't have enough time((((
    }
}
