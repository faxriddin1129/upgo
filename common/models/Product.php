<?php

namespace common\models;

use common\components\ActiveRecord;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%product}}".
 *
 * @property int $id
 * @property string|null $name
 * @property float|null $get_price
 * @property float|null $sell_price
 * @property int|null $file_id
 * @property int|null $measure_id
 * @property int|null $category_id
 * @property string|null $description
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $user_id
 * @property int|null $status
 *
 * @property Category $category
 * @property User $createdBy
 * @property File $file
 * @property Measure $measure
 * @property OrderProduct[] $orderProducts
 * @property StockProduct[] $stockProducts
 * @property User $updatedBy
 * @property User $user
 */
class Product extends ActiveRecord
{

    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            BlameableBehavior::class
        ];
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
    public static function tableName()
    {
        return '{{%product}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['get_price', 'sell_price', 'file_id', 'measure_id', 'category_id', 'description', 'name'], 'required'],
            [['get_price', 'sell_price'], 'number'],
            [['file_id', 'measure_id', 'category_id', 'created_at', 'updated_at', 'created_by', 'updated_by', 'user_id', 'status'], 'integer'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['file_id'], 'exist', 'skipOnError' => true, 'targetClass' => File::class, 'targetAttribute' => ['file_id' => 'id']],
            [['measure_id'], 'exist', 'skipOnError' => true, 'targetClass' => Measure::class, 'targetAttribute' => ['measure_id' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']],
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
            'name' => Yii::t('app', 'Name'),
            'get_price' => Yii::t('app', 'Get Price'),
            'sell_price' => Yii::t('app', 'Sell Price'),
            'file_id' => Yii::t('app', 'File ID'),
            'measure_id' => Yii::t('app', 'Measure ID'),
            'category_id' => Yii::t('app', 'Category ID'),
            'description' => Yii::t('app', 'Description'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'user_id' => Yii::t('app', 'User ID'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
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
     * Gets query for [[Measure]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMeasure()
    {
        return $this->hasOne(Measure::class, ['id' => 'measure_id']);
    }

    /**
     * Gets query for [[OrderProducts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderProducts()
    {
        return $this->hasMany(OrderProduct::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[StockProducts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStockProducts()
    {
        return $this->hasMany(StockProduct::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[UpdatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'updated_by']);
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

    public function fields()
    {
        return [
            'id',
            'name',
            'get_price',
            'sell_price',
            'file_id',
            'file' => function($model){
                return $model->file->url;
            },
            'measure_id',
            'measure' => function($model){
                return $model->measure->name;
            },
            'category_id',
            'category' => function($model){
                return $model->category->name;
            },
            'description',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
            'user_id',
            'status',
            'diller' => function($model){
                return $model->user->userDetail;
            },
            'owner' => function($model){
                return $this->createdBy->userDetail;
            }
        ];
    }
}
