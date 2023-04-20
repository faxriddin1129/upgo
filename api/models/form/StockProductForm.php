<?php

namespace api\models\form;

use common\models\Product;
use common\models\Stock;
use common\models\StockProduct;
use common\models\User;
use yii\base\Model;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

class StockProductForm extends Model
{

    public $product_id;
    public $count;

    public function rules()
    {
        return [
            [['product_id', 'count'], 'required'],
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
            throw new BadRequestHttpException('Stock not found!');
        }

        $stockProduct = StockProduct::findOne(['product_id' => $this->product_id, 'stock_id' => $stock->id]);
        if (!$stockProduct){
            throw new NotFoundHttpException('Stock Product not found!');
        }
        $stockProduct->count += $this->count;
        if (!$stockProduct->save()){
            $this->addErrors($stockProduct->errors);
            return false;
        }

        return $stockProduct;

    }

}