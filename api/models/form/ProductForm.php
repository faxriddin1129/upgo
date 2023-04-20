<?php

namespace api\models\form;

use common\models\Category;
use common\models\File;
use common\models\Measure;
use common\models\Product;
use common\models\Stock;
use common\models\StockProduct;
use common\models\User;
use yii\base\Model;
use yii\web\BadRequestHttpException;

class ProductForm extends Model
{

    public $name;
    public $description;
    public $category_id;
    public $category_name;
    public $measure_id;
    public $measure_name;
    public $file_id;
    public $sell_price;
    public $get_price;
    public $id;

    public function rules()
    {
        return [
            [['get_price', 'sell_price', 'file_id', 'description', 'name'], 'required'],
            [['get_price', 'sell_price'], 'number'],
            [['file_id', 'measure_id', 'category_id'], 'integer'],
            [['description'], 'string'],
            [['name', 'category_name', 'measure_name'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
            [['file_id'], 'exist', 'skipOnError' => true, 'targetClass' => File::class, 'targetAttribute' => ['file_id' => 'id']],
            [['measure_id'], 'exist', 'skipOnError' => true, 'targetClass' => Measure::class, 'targetAttribute' => ['measure_id' => 'id']],
        ];
    }

    public function save(){

        if (!$this->validate()){
            return false;
        }

        if (!$this->category_name and !$this->category_id){
            throw new BadRequestHttpException('Enter Category or Name!');
        }

        if (!$this->measure_name and !$this->measure_id){
            throw new BadRequestHttpException('Enter Measure or Name!');
        }


        $transaction = \Yii::$app->db->beginTransaction();

        $productModel = new Product();
        if (\Yii::$app->user->identity['role'] == User::ROLE_SUP_DILLER){
            $productModel->user_id = \Yii::$app->user->identity['parent_id'];
        }
        if (\Yii::$app->user->identity['role'] == User::ROLE_DILLER or \Yii::$app->user->identity['role'] == User::ROLE_ADMIN){
            $productModel->user_id = \Yii::$app->user->id;
        }
        $productModel->status = Product::STATUS_ACTIVE;
        $productModel->setAttributes($this->attributes);

        if ($this->category_name){
            $categoryModel = new Category();
            $categoryModel->name = $this->category_name;
            if (!$categoryModel->save()){
                $transaction->rollBack();
                $this->addErrors($categoryModel->getErrors());
                return false;
            }
            $productModel->category_id = $categoryModel->id;
        }


        if ($this->measure_name){
            $measureModel = new Measure();
            $measureModel->name = $this->category_name;
            if (!$measureModel->save()){
                $transaction->rollBack();
                $this->addErrors($measureModel->getErrors());
                return false;
            }
            $productModel->measure_id = $measureModel->id;
        }

        if (!$productModel->save()){
            $transaction->rollBack();
            $this->addErrors($productModel->getErrors());
            return false;
        }

        $stockProductModel = new StockProduct();
        $stock_id = false;
        if (\Yii::$app->user->identity['role'] == User::ROLE_DILLER){
            $stock_id = Stock::findOne(['user_id' => \Yii::$app->user->id]);
        }
        if (\Yii::$app->user->identity['role'] == User::ROLE_SUP_DILLER){
            $stock_id = Stock::findOne(['user_id' => \Yii::$app->user->identity['parent_id']]);
        }
        if (!$stock_id){
            throw new BadRequestHttpException('Permission denied!');
        }
        $stockProductModel->product_id = $productModel->id;
        $stockProductModel->stock_id = $stock_id->id;
        $stockProductModel->count = 0;
        if (!$stockProductModel->save()){
            $transaction->rollBack();
            $this->addErrors($stockProductModel->getErrors());
            return false;
        }

        $transaction->commit();
        return $productModel;
    }

    public function update(){
        if (!$this->validate()){
            return false;
        }

        if (!$this->category_id){
            throw new BadRequestHttpException('Enter Category!');
        }

        if (!$this->measure_id){
            throw new BadRequestHttpException('Enter Measure!');
        }


        $transaction = \Yii::$app->db->beginTransaction();
        $productModel = Product::findOne(['id' => $this->id]);
        $productModel->setAttributes($this->attributes);
        if (!$productModel->save()){
            $transaction->rollBack();
            $this->addErrors($productModel->getErrors());
            return false;
        }

        $transaction->commit();
        return $productModel;
    }
}