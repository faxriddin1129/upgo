<?php

namespace common\models;

use common\components\ActiveRecord;
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
 * @property string|null $phone
 * @property string|null $full_name
 *
 * @property Order[] $orders
 * @property Region $region
 * @property User $user
 * @property WorkingDays[] $workingDays
 */
class Client extends ActiveRecord
{

    const STATUS_DELETED = 0;
    const STATUS_ACTIVE =  10;
    const STATUS_INACTIVE =  9;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%client}}';
    }

    public static function dropdownStatus(){

        return [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_INACTIVE => 'InActive',
            self::STATUS_DELETED => 'Deleted',
        ];

    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'region_id', 'file_id', 'status', 'address', 'location', 'legal_name', 'name', 'nearby', 'inn', 'phone', 'full_name'], 'required'],
            [['user_id', 'region_id', 'file_id', 'status'], 'integer'],
            [['address', 'location', 'deleted_description'], 'string'],
            [['legal_name', 'name', 'nearby', 'inn', 'phone', 'full_name'], 'string', 'max' => 255],
            [['region_id'], 'exist', 'skipOnError' => true, 'targetClass' => Region::class, 'targetAttribute' => ['region_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['file_id'], 'exist', 'skipOnError' => true, 'targetClass' => File::class, 'targetAttribute' => ['file_id' => 'id']],
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
            'phone' => Yii::t('app', 'Phone'),
            'full_name' => Yii::t('app', 'Full Name'),
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
     * Gets query for [[File]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(File::class, ['id' => 'file_id']);
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

    public function fields()
    {
        return [
            'id',
            'legal_name',
            'name',
            'address',
            'location',
            'nearby',
            'region_id',
            'region' => function($model){
                return $model->region->name;
            },
            'inn',
            'file_id',
            'file' => function($model){
                return $model->file->url;
            },
            'status',
            'deleted_description',
            'phone',
            'full_name',
        ];
    }
    public function extraFields()
    {
        return [
            'diller' => function($model){
                return $model->user->userDetail;
            },
            'debt' => function($model){
                return Order::find()->andWhere(['client_id' => $model->id])->andWhere(['debt' => Order::DEBT_ACTIVE])->all();
            }
        ];
    }
}
