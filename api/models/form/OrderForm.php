<?php

namespace api\models\form;

use common\models\Client;
use common\models\DebtKill;
use common\models\Order;
use common\models\OrderProduct;
use common\models\PaymentType;
use common\models\Product;
use yii\base\Model;
use yii\web\BadRequestHttpException;

class OrderForm extends Model
{

    public $payment_type_id;
    public $delivery_time;
    public $client_id;
    public $products;
    public $total_price;
    public $cashback;

    public function rules()
    {
        return [
            [['payment_type_id', 'delivery_time', 'client_id', 'products'], 'required'],
            [['payment_type_id', 'delivery_time', 'client_id'], 'integer'],
            [['total_price','cashback'], 'number'],
            [['products'], 'safe'],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Client::class, 'targetAttribute' => ['client_id' => 'id']],
            [['payment_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => PaymentType::class, 'targetAttribute' => ['payment_type_id' => 'id']],
        ];
    }

    public function save(){
        if (!$this->validate()){
            return false;
        }

        if (!is_array($this->products)){
            throw new BadRequestHttpException('Products only array');
        }

        $transaction = \Yii::$app->db->beginTransaction();
        $model = new Order();
        $model->user_id = \Yii::$app->user->id;
        $model->client_id = $this->client_id;
        $model->payment_type_id = $this->payment_type_id;
        $model->cashback = $this->cashback;
        $model->delivery_time = $this->delivery_time;
        $model->pay_status = Order::STATUS__NOT_PAYED;
        $model->status = Order::STATUS_DEBTOR;
        $model->debt = Order::DEBT_ACTIVE;
        if (!$model->save()){
            $transaction->rollBack();
            $this->addErrors($model->getErrors());
            return false;
        }

        foreach ($this->products as $product) {
            $orderProductModel = new OrderProduct();
            $orderProductModel->order_id = $model->id;
            $orderProductModel->setAttributes($product);
            if (!$orderProductModel->save()){
                $transaction->rollBack();
                $this->addErrors($orderProductModel->getErrors());
                return false;
            }
        }

        $get_price = 0;
        $total_price = 0;
        $productsOreder = OrderProduct::find()->andWhere(['order_id' => $model->id])->asArray()->all();
        foreach ($productsOreder as $product) {
            $pro = Product::findOne(['id' => $product['product_id']]);
            $total_price += ($pro->sell_price * $product['count']);
            $get_price += ($pro->get_price * $product['count']);
        }

        $model->total_price = $total_price;
        $model->get_price = $get_price;
        if (!$model->save()){
            $transaction->rollBack();
            $this->addErrors($model->getErrors());
            return false;
        }

        $modelDebt = new DebtKill();
        $modelDebt->order_id = $model->id;
        $modelDebt->debt_price = $total_price;
        if (!$modelDebt->save()){
            $transaction->rollBack();
            $this->addErrors($modelDebt->getErrors());
            return false;
        }


        $transaction->commit();
        return $model;
    }

}