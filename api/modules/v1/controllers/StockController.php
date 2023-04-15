<?php

namespace api\modules\v1\controllers;

use api\models\form\StockProductDeleteForm;
use api\models\form\StockProductForm;
use api\models\search\StockProductSearch;
use common\components\ApiController;
use common\models\Stock;
use common\models\StockProduct;
use common\models\User;
use yii\web\BadRequestHttpException;

class StockController extends ApiController
{

    public $modelClass = StockProduct::class;
    public $searchModel = StockProductSearch::class;

    public function actions()
    {
        $parent = parent::actions();
        unset($parent['index']);
        unset($parent['view']);
        return $parent;
    }

    public function actionIndex()
    {
        $stock_id = false;
        if (\Yii::$app->user->identity['role'] == User::ROLE_DILLER){
            $stock_id = Stock::findOne(['user_id' => \Yii::$app->user->id]);
        }
        if (\Yii::$app->user->identity['role'] == User::ROLE_SUP_DILLER){
            $stock_id = Stock::findOne(['user_id' => \Yii::$app->user->identity['parent_id']]);
        }
        if (!$stock_id){
            throw new BadRequestHttpException('Stock not found!');
        }

        $search = new StockProductSearch(['stock_id' => $stock_id->id]);
        $dataProvider = $search->search(\Yii::$app->request->queryParams);

        return $dataProvider;
    }

    public function actionCreate(){
        $queryParams = \Yii::$app->getRequest()->getBodyParams();
        $model = new StockProductForm();
        $model->setAttributes($queryParams);
        $response = $model->save();
        if (!$response){
            return $model;
        }

        return $response;
    }

    public function actionDelete(){
        $queryParams = \Yii::$app->getRequest()->getBodyParams();
        $model = new StockProductDeleteForm();
        $model->setAttributes($queryParams);
        $response = $model->save();
        if (!$response){
            return $model;
        }

        return $response;
    }


}