<?php

namespace common\activeRecords;

/**
 * This is the model class for table "material_items".
 *
 * @property int $id
 * @property string $name
 * @property int $status
 */
class MaterialItemsModel extends \yii\db\ActiveRecord
{
    public const AVAILABLE_FOR_RAFFLING = 0;
    public const WAITING_FOR_SENDING = 1;
    public const WAS_SENT = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'material_items';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['status'], 'default', 'value' => self::AVAILABLE_FOR_RAFFLING],
            [['status'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'status' => 'Status',
        ];
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getStatus(): int
    {
        return $this->status;
    }
}
