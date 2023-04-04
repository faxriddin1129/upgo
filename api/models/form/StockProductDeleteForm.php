<?php

namespace api\models\form;

use common\models\Product;
use common\models\RemoveProduct;
use common\models\Stock;
use common\models\StockProduct;
use common\models\User;
use yii\base\Model;
use yii\web\BadRequestHttpException;

class StockProductDeleteForm extends Model
{

    public $product_id;
    public $count;
    public $comment;

    public function rules()
    {
        return [
            [['product_id', 'count', 'comment'], 'required'],
            [['comment'], 'string'],
            [['count'], 'integer'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],

        ];
    }


    public function save(){
        if (!$this->validate()){
            return false;
        }

        $stock = false;
        if (\Yii::$app->user->identity['role'] == User::ROLE_DILLER){
            $stock = Stock::findOne(['user_id' => \Yii::$app->user->id]);
        }
        if (\Yii::$app->user->identity['role'] == User::ROLE_SUP_DILLER){
            $stock = Stock::findOne(['user_id' => \Yii::$app->user->identity['parent_id']]);
        }

        if (!$stock){
            throw new BadRequestHttpException('Error!');
        }

        $stockProduct = StockProduct::findOne(['product_id' => $this->product_id, 'stock_id' => $stock->id]);
        if (!$stockProduct){
            throw new BadRequestHttpException('Stock product not found!');
        }

        if ($stockProduct->count < $this->count){
            throw new BadRequestHttpException('Not enough product!');
        }

        $transaction = \Yii::$app->db->beginTransaction();
        $stockProduct->count -= $this->count;
        if (!$stockProduct->save()){
            $transaction->rollBack();
            $this->addErrors($stockProduct->errors);
            return false;
        }

        $removeModel = new RemoveProduct();
        $removeModel->setAttributes($this->attributes);
        $removeModel->stock_id = $stock->id;
        if (!$removeModel->save()){
            $transaction->rollBack();
            $this->addErrors($removeModel->errors);
            return false;
        }

        $transaction->commit();
        return $stockProduct;

    }

}