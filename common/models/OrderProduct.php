<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%order_product}}".
 *
 * @property int $id
 * @property int|null $product_id
 * @property float|null $count
 * @property int|null $order_id
 *
 * @property Order $order
 * @property Product $product
 */
class OrderProduct extends \yii\db\ActiveRecord
{
    public $old_count;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%order_product}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'order_id', 'count', 'stock_product_id'], 'required'],
            [['product_id', 'order_id', 'old_count'], 'integer'],
            [['count'], 'number'],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::class, 'targetAttribute' => ['order_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
            [['stock_product_id'], 'exist', 'skipOnError' => true, 'targetClass' => StockProduct::class, 'targetAttribute' => ['stock_product_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'product_id' => Yii::t('app', 'Product ID'),
            'count' => Yii::t('app', 'Count'),
            'order_id' => Yii::t('app', 'Order ID'),
        ];
    }

    /**
     * Gets query for [[Order]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::class, ['id' => 'order_id']);
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    public function fields()
    {
        return [
            'id',
            'product_id' => function($model){
                return $model->product->id;
            },
            'count',
            'stock_product_id',
            'product' => function($model){
                return $model->product;
            },
        ];
    }
}
