<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%day}}".
 *
 * @property int $id
 * @property string|null $name
 *
 * @property WorkingDays[] $workingDays
 */
class Day extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%day}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
        ];
    }

    /**
     * Gets query for [[WorkingDays]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWorkingDays()
    {
        return $this->hasMany(WorkingDays::class, ['day_id' => 'id']);
    }
}
