<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%order}}".
 *
 * @property int $id
 * @property int|null $client_id
 * @property int|null $user_id
 * @property int|null $payment_type_id
 * @property int|null $cashback
 * @property int|null $delivery_time
 * @property float|null $total_price
 * @property float|null $debt
 * @property int|null $pay_status
 * @property float|null $get_price
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $diller_id
 * @property int|null $update_total_price
 * @property int|null $payment_price
 *
 * @property Client $client
 * @property User $createdBy
 * @property DebtKill[] $debtKills
 * @property User $diller
 * @property OrderProduct[] $orderProducts
 * @property PaymentType $paymentType
 * @property User $updatedBy
 * @property User $user
 */
class Order extends \yii\db\ActiveRecord
{

    const STATUS_NEW = 0;
    const STATUS_PENDING = 1;
    const STATUS_APPROVED = 2;

    const STATUS_PAYED = 1;
    const STATUS_DEBTOR = 0;

    const DEBT_ACTIVE = 1;
    const DEBT_INACTIVE = 0;

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            BlameableBehavior::class
        ];
    }

    public static function dropdownStatus(){

        return [
            self::STATUS_NEW => 'New',
            self::STATUS_PENDING => 'Pending',
            self::STATUS_APPROVED => 'Approved',
        ];

    }

    public static function dropdownStatusPay(){

        return [
            self::STATUS_PAYED => 'Payed',
            self::STATUS_DEBTOR => 'Not Payed',
        ];

    }


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%order}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client_id', 'user_id', 'payment_type_id', 'cashback', 'delivery_time', 'pay_status', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by', 'diller_id'], 'integer'],
            [['total_price', 'debt', 'get_price', 'update_total_price', 'payment_price'], 'number'],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Client::class, 'targetAttribute' => ['client_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['diller_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['diller_id' => 'id']],
            [['payment_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => PaymentType::class, 'targetAttribute' => ['payment_type_id' => 'id']],
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
            'client_id' => Yii::t('app', 'Client ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'payment_type_id' => Yii::t('app', 'Payment Type ID'),
            'cashback' => Yii::t('app', 'Cashback'),
            'delivery_time' => Yii::t('app', 'Delivery Time'),
            'total_price' => Yii::t('app', 'Total Price'),
            'debt' => Yii::t('app', 'Debt'),
            'pay_status' => Yii::t('app', 'Pay Status'),
            'get_price' => Yii::t('app', 'Get Price'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'diller_id' => Yii::t('app', 'Diller ID'),
        ];
    }

    /**
     * Gets query for [[Client]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Client::class, ['id' => 'client_id']);
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
     * Gets query for [[DebtKills]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDebtKills()
    {
        return $this->hasMany(DebtKill::class, ['order_id' => 'id']);
    }

    /**
     * Gets query for [[Diller]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDiller()
    {
        return $this->hasOne(User::class, ['id' => 'diller_id']);
    }

    /**
     * Gets query for [[OrderProducts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderProducts()
    {
        return $this->hasMany(OrderProduct::class, ['order_id' => 'id']);
    }

    /**
     * Gets query for [[PaymentType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPaymentType()
    {
        return $this->hasOne(PaymentType::class, ['id' => 'payment_type_id']);
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
            'client_id',
            'client' => function($model){
                return $model->client;
            },
            'diller_id',
            'diller' => function($model){
                return $model->diller;
            },
            'user_id',
            'user' => function($model){
                return $model->user;
            },
            'payment_type_id',
            'payment_type' => function($model){
                return $model->paymentType;
            },
            'cashback',
            'delivery_time',
            'total_price',
            'payment_price',
            'update_total_price',
            'get_price',
            'debt',
            'debt_kil' => function($model){
                return $model->debtKills;
            },
            'already_debt' => function($model){
                $orders =  Order::find()->andWhere(['debt' => Order::DEBT_ACTIVE])->andWhere(['diller_id' => $this->diller_id]);
            },
            'pay_status',
            'pay_status_format' => function($model){
                return self::dropdownStatusPay()[$model->pay_status];
            },
            'status',
            'status_format' => function($model){
                return self::dropdownStatus()[$model->status];
            },
            'products' => function($model){
                return $model->orderProducts;
            },
            'created_at',
            'updated_at',
        ];
    }

    public function extraFields()
    {
        return [
            'owner' => function($model){
                return [
                    'created_by' => [
                        'user_id' => $model->created_by,
                        'phone' => $model->createdBy->first_name,
                    ],
                    'updated_by' => [
                        'user_id' => $model->updated_by,
                        'phone' => $model->updatedBy->first_name,
                    ],
                ];
            },
        ];
    }
}
