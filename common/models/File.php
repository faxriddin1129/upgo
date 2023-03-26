<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%file}}".
 *
 * @property int $id
 * @property string|null $url
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Product[] $products
 * @property UserDetail[] $userDetails
 */
class File extends \yii\db\ActiveRecord
{

    public function behaviors()
    {
        return [
            TimestampBehavior::class
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%file}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['url'], 'string'],
            [['created_at', 'updated_at'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'url' => Yii::t('app', 'Url'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[Products]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::class, ['file_id' => 'id']);
    }

    /**
     * Gets query for [[UserDetails]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserDetails()
    {
        return $this->hasMany(UserDetail::class, ['file_id' => 'id']);
    }
}
