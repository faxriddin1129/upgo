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
 *
 * @property Client $client
 * @property User $createdBy
 * @property DebtKill[] $debtKills
 * @property OrderProduct[] $orderProducts
 * @property PaymentType $paymentType
 * @property User $updatedBy
 * @property User $user
 */
class Order extends \yii\db\ActiveRecord
{

    const STATUS_NEW = 0;
    const STATUS_PENDING = 1;
    const STATUS_DEBTOR = 2;
    const STATUS_APPROVED = 3;

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
            self::STATUS_DEBTOR => 'Debtor',
            self::STATUS_APPROVED => 'Approved',
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
            [['client_id', 'user_id', 'payment_type_id', 'cashback', 'delivery_time', 'pay_status', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['total_price', 'debt', 'get_price'], 'number'],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Client::class, 'targetAttribute' => ['client_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
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
}
