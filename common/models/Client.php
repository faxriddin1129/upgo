<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%client}}".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $legal_name
 * @property string|null $name
 * @property string|null $address
 * @property string|null $location
 * @property string|null $nearby
 * @property int|null $region_id
 * @property string|null $inn
 * @property int|null $file_id
 * @property int|null $status
 * @property string|null $deleted_description
 *
 * @property Order[] $orders
 * @property Region $region
 * @property User $user
 * @property WorkingDays[] $workingDays
 */
class Client extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%client}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'region_id', 'file_id', 'status'], 'integer'],
            [['address', 'location', 'deleted_description'], 'string'],
            [['legal_name', 'name', 'nearby', 'inn'], 'string', 'max' => 255],
            [['region_id'], 'exist', 'skipOnError' => true, 'targetClass' => Region::class, 'targetAttribute' => ['region_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'legal_name' => Yii::t('app', 'Legal Name'),
            'name' => Yii::t('app', 'Name'),
            'address' => Yii::t('app', 'Address'),
            'location' => Yii::t('app', 'Location'),
            'nearby' => Yii::t('app', 'Nearby'),
            'region_id' => Yii::t('app', 'Region ID'),
            'inn' => Yii::t('app', 'Inn'),
            'file_id' => Yii::t('app', 'File ID'),
            'status' => Yii::t('app', 'Status'),
            'deleted_description' => Yii::t('app', 'Deleted Description'),
        ];
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::class, ['client_id' => 'id']);
    }

    /**
     * Gets query for [[Region]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(Region::class, ['id' => 'region_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Gets query for [[WorkingDays]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWorkingDays()
    {
        return $this->hasMany(WorkingDays::class, ['client_id' => 'id']);
    }
}
