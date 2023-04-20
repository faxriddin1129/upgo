<?php

namespace api\models\form;

use common\models\Client;
use common\models\DebtKill;
use common\models\Order;
use common\models\OrderProduct;
use common\models\PaymentType;
use common\models\Product;
use common\models\User;
use yii\base\Model;
use yii\db\Exception;
use yii\db\StaleObjectException;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

class OrderForm extends Model
{

    public $payment_type_id;
    public $delivery_time;
    public $client_id;
    public $products;
    public $total_price;
    public $order_id;
    public $cashback;
    public $payment_price;
    public $debt_price;

    public function rules()
    {
        return [
            [['payment_type_id', 'delivery_time', 'client_id', 'products'], 'required'],
            [['payment_type_id', 'delivery_time', 'client_id'], 'integer'],
            [['total_price','cashback','payment_price', 'payment_price'], 'number'],
            [['products'], 'safe'],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Client::class, 'targetAttribute' => ['client_id' => 'id']],
            [['payment_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => PaymentType::class, 'targetAttribute' => ['payment_type_id' => 'id']],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::class, 'targetAttribute' => ['order_id' => 'id']],
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
        $model->pay_status = Order::STATUS_DEBTOR;
        $model->status = Order::STATUS_NEW;
        $model->debt = Order::DEBT_ACTIVE;

        if (\Yii::$app->user->identity['role'] == User::ROLE_DILLER){
            $model->diller_id = \Yii::$app->user->id;
        }
        if (\Yii::$app->user->identity['role'] == User::ROLE_SUP_DILLER){
            $model->diller_id = \Yii::$app->user->identity['parent_id'];
        }

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
        $model->update_total_price = $total_price;
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


    /**
     * @throws \Throwable
     * @throws Exception
     * @throws StaleObjectException
     * @throws BadRequestHttpException
     */
    public function update(){
        if (!$this->validate()){
            return false;
        }

        if (!is_array($this->products)){
            throw new BadRequestHttpException('Products only array');
        }

        $transaction = \Yii::$app->db->beginTransaction();
        $model = Order::findOne(['id' => $this->order_id]);
        $model->payment_type_id = $this->payment_type_id;
        $model->cashback = $this->cashback;
        $model->delivery_time = $this->delivery_time;
        if (!$model->save()){
            $transaction->rollBack();
            $this->addErrors($model->getErrors());
            return false;
        }


        foreach ($this->products as $product) {
            $orderProductModel = OrderProduct::findOne(['id' => $product['id']]);
            if (!$orderProductModel){
                throw new NotFoundHttpException('Order Product not found!');
            }
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

        $model->update_total_price = $total_price;
        $model->get_price = $get_price;
        if (!$model->save()){
            $transaction->rollBack();
            $this->addErrors($model->getErrors());
            return false;
        }

        $modelDebt = DebtKill::findOne(['order_id' => $model->id]);
        $modelDebt->order_id = $model->id;
        $modelDebt->debt_price = ($total_price - $model->payment_price);
        if (!$modelDebt->save()){
            $transaction->rollBack();
            $this->addErrors($modelDebt->getErrors());
            return false;
        }


        if ($this->payment_price){
            if ($model->debt == Order::DEBT_INACTIVE){
                $transaction->rollBack();
                throw new BadRequestHttpException('Already Payment!');
            }
            $model->payment_price += $this->payment_price;
            if ($model->payment_price > $model->update_total_price){
                $transaction->rollBack();
                throw new BadRequestHttpException('Big price!');
            }

            if ($model->payment_price == $model->update_total_price){
                $model->debt = Order::DEBT_INACTIVE;
            }
            if ($model->debt == Order::DEBT_ACTIVE){
                $modelDebt->debt_price = ($model->update_total_price - $model->payment_price);
            }
            $model->save();
            $modelDebt->save();
        }



        $transaction->commit();
        return $model;
    }
}